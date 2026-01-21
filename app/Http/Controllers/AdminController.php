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

    public function detailLaporan($id)
    {
        $laporan = Laporan::find($id);

        if (!$laporan) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }

        // Kirim data dalam format JSON
        return response()->json($laporan);
    }

    public function updateStatus(Request $request, $id)
    {
        // 1. Cari Laporan
        $laporan = Laporan::find($id);

        $laporan->update([
            'status' => $request->status ?? 'selesai'
        ]);

        return redirect()->back()->with('success', 'Status laporan #' . $id . ' berhasil diperbarui menjadi SELESAI.');
    }

    public function wp()
    {
        $laporan = Laporan::all(); //Mengambil semua data laporan

        if ($laporan->isEmpty()) {
            return redirect()->back()->with('error', 'Data laporan masih kosong.');
        }

        // 1. Tentukan Bobot Kriteria (C1-C5)
        // C1:Volume, C2:Bau, C3:Jenis, C4:Lokasi, C5:Lama
        $w = [0.30, 0.15, 0.15, 0.20, 0.20];

        // 2. Perbaikan Bobot (Normalisasi Bobot agar Total = 1)
        $total_w = array_sum($w);
        $wn = array_map(fn($val) => $val / $total_w, $w);

        $hasil_wp = [];

        foreach ($laporan as $l) {
            // 3. Hitung Vektor S (Pemangkatan Nilai Kriteria dengan Bobot)
            // Karena semua kriteria bersifat "Benefit", pangkat bernilai positid (+)
            $s = pow($l->c1, $wn[0]) *
                pow($l->c2, $w[1]) *
                pow($l->c3, $w[2]) *
                pow($l->c4, $w[3]) *
                pow($l->c5, $w[4]);

            $hasil_wp[] = [
                'id' => $l->id,
                'nik' => $l->nik_pelapor,
                'vektor_s' => $s,
            ];
        }

        // 4. Hitung Vektor V (Nilai Preferensi)
        $total_s = array_sum(array_column($hasil_wp, 'vektor_s'));

        foreach ($hasil_wp as &$h) {
            $h['vektor_v'] = $h['vektor_s'] / $total_s;
        }

        // 5. Ranking berdasarkan Vektor V terbesar (DESC)
        $hasil_wp = collect($hasil_wp)->sortByDesc('vektor_v')->values()->all();

        return view('admin.wp', compact('hasil_wp', 'laporan'));
    }

    public function getVikorData($laporan)
    {
        $w = [0.30, 0.15, 0.15, 0.20, 0.20]; // Bobot C1-C5
        $kriteria = ['c1', 'c2', 'c3', 'c4', 'c5'];

        // Cari f* (max) dan f- (min)
        foreach ($kriteria as $c) {
            $f_star[$c] = $laporan->max($c);
            $f_min[$c] = $laporan->min($c);
        }

        $temp = [];
        foreach ($laporan as $l) {
            $s = 0;
            $r = 0;
            foreach ($kriteria as $i => $c) {
                $rentang = ($f_star[$c] - $f_min[$c]) ?: 1;
                $val = $w[$i] * ($f_star[$c] - $l->$c) / $rentang;
                $s += $val;
                if ($val > $r) $r = $val;
            }
            $temp[] = ['id' => $l->id, 'nik' => $l->nik_pelapor, 's' => $s, 'r' => $r];
        }


        $s_star = collect($temp)->min('s');
        $s_min = collect($temp)->max('s');
        $r_star = collect($temp)->min('r');
        $r_min = collect($temp)->max('r');

        foreach ($temp as &$t) {
            $v = 0.5; // Strategi bobot mayoritas
            $qs = ($s_min - $s_star) ?: 1;
            $qr = ($r_min - $r_star) ?: 1;
            $t['q'] = ($v * ($t['s'] - $s_star) / $qs) + ((1 - $v) * ($t['r'] - $r_star) / $qr);
        }

        // Urutkan berdasarkan Q terkecil (Ascending)
        return collect($temp)->sortBy('q')->values()->all();
    }

    public function getWpData($laporan)
    {
        $w = [0.30, 0.15, 0.15, 0.20, 0.20]; // Bobot C1-C5
        $total_w = array_sum($w);
        $wn = array_map(fn($v) => $v / $total_w, $w); // Normalisasi bobot agar total = 1

        $temp = [];
        foreach ($laporan as $l) {
            // Hitung Vektor S
            $s_vec = pow($l->c1, $wn[0]) * pow($l->c2, $wn[1]) * pow($l->c3, $wn[2]) * pow($l->c4, $wn[3]) * pow($l->c5, $wn[4]);
            $temp[] = ['id' => $l->id, 'nik' => $l->nik_pelapor, 's_vec' => $s_vec];
        }

        $total_s = collect($temp)->sum('s_vec');
        foreach ($temp as &$t) {
            // Hitung Vektor V (Nilai Preferensi)
            $t['v_vec'] = $t['s_vec'] / ($total_s ?: 1);
        }

        // Urutkan berdasarkan Vektor V terbesar (Descending)
        return collect($temp)->sortByDesc('v_vec')->values()->all();
    }

    public function perbandingan()
    {
        $laporan = Laporan::all();
        $n = $laporan->count();

        if ($n < 2) return redirect()->back()->with('error', 'Minimal butuh 2 data untuk korelasi.');

        $vikor = $this->getVikorData($laporan);
        $wp = $this->getWpData($laporan);

        $perbandingan = [];
        $sum_d2 = 0;

        foreach ($laporan as $l) {
            // Cari Rank VIKOR (Q terkecil = Rank 1)
            $rank_vikor = collect($vikor)->search(fn($v) => $v['id'] == $l->id) + 1;
            // Cari Rank WP (V terbesar = Rank 1)
            $rank_wp = collect($wp)->search(fn($w) => $w['id'] == $l->id) + 1;

            $d = $rank_vikor - $rank_wp;
            $d2 = pow($d, 2);
            $sum_d2 += $d2;

            // PERBAIKAN: Pastikan key array ('d' dan 'd_kuadrat') sama dengan di Blade
            $perbandingan[] = [
                'id' => $l->id,
                'nik' => $l->nik_pelapor,
                'rank_vikor' => $rank_vikor,
                'rank_wp' => $rank_wp,
                'd' => $d,             // Ini yang sebelumnya hilang
                'd_kuadrat' => $d2     // Sesuaikan nama ini dengan $p['d_kuadrat'] di Blade
            ];
        }

        // Hitung Rumus Spearman dan simpan dalam variabel $spearman
        $spearman = 1 - ((6 * $sum_d2) / ($n * (pow($n, 2) - 1)));

        // Kirim variabel $spearman ke view sesuai permintaan Blade Anda
        return view('admin.perbandingan', compact('perbandingan', 'spearman', 'n'));
    }
}
