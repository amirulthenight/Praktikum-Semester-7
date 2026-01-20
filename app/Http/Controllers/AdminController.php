<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function index()
    {
        $laporan = Laporan::orderBy('created_at', 'desc')->get();
        return view('admin.dashboard', compact('laporan'));
    }

    public function peta()
    {
        $laporan = Laporan::all(); //Mengambil semua data laporan
        return view('admin.peta', compact('laporan'));
    }

    public function vikor()
    {
        $laporan = Laporan::all(); //Mengambil semua data laporan

        if ($laporan->isEmpty()) {
            return redirect()->back()->with('error', 'Data laporan masih kosong.');
        }

        // --- PROSES SPK VIKOR ---

        // 1. Tentukan Boobot (Contoh: Total harus 1)
        //  // C1:Volume, C2:Bau, C3:Jenis, C4:Lokasi, C5:Lama

        $w = [0.30, 0.15, 0.15, 0.20, 0.20];

        // 2. Cari Nilai Terbaik (f*) dan Terburuk (f-)
        // Karena semua kriteria bersifat "Benefit" (Semakin besar semakin prioritas)

        $f_star = [
            'c1' => $laporan->max('c1'),
            'c2' => $laporan->max('c2'),
            'c3' => $laporan->max('c3'),
            'c4' => $laporan->max('c4'),
            'c5' => $laporan->max('c5'),
        ];

        $f_minus = [
            'c1' => $laporan->min('c1'),
            'c2' => $laporan->min('c2'),
            'c3' => $laporan->min('c3'),
            'c4' => $laporan->min('c4'),
            'c5' => $laporan->min('c5'),
        ];

        $hasil_vikor = [];

        foreach ($laporan as $l) {
            $s = 0; // Utility Measure
            $r = 0; // Regret Measure

            foreach (['c1', 'c2', 'c3', 'c4', 'c5'] as $index => $c) {
                // Rumus Normalisasi VIKOR: w * (f* - fi) / (f* - f-)
                $pembagi = ($f_star[$c] - $f_minus[$c]);
                $nilai_n = ($pembagi == 0) ? 0 : $w[$index] * ($f_star[$c] - $l->$c) / $pembagi;

                $s += $nilai_n;
                if ($nilai_n > $r) {
                    $r = $nilai_n;
                }
            }

            $hasil_vikor[] = [
                'id' => $l->id,
                'nik' => $l->nik_pelapor,
                's' => $s,
                'r' => $r,
            ];
        }


        // 3. Menghitung Nilai Q (Indeks VIKOR)
        $s_star = collect($hasil_vikor)->min('s');
        $s_minus = collect($hasil_vikor)->max('s');
        $r_star = collect($hasil_vikor)->min('r');
        $r_minus = collect($hasil_vikor)->max('r');
        $v = 0.5; // Strategi bobot mayoritas

        foreach ($hasil_vikor as &$h) {
            $pembagi_s = ($s_minus - $s_star);
            $pembagi_r = ($r_minus - $r_star);

            $term_s = ($pembagi_s == 0) ? 0 : ($h['s'] - $s_star) / $pembagi_s;
            $term_r = ($pembagi_r == 0) ? 0 : ($h['r'] - $r_star) / $pembagi_r;

            $h['q'] = ($v * $term_s) + ((1 - $v) * $term_r);
        }

        // Urutkan berdasarkan Q terkecil (Semakin kecil Q, semakin prioritas)
        $hasil_vikor = collect($hasil_vikor)->sortBy('q')->values()->all();

        return view('admin.vikor', compact('hasil_vikor', 'laporan'));
    }
}
