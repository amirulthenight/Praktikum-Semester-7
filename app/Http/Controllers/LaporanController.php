<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class LaporanController extends Controller
{
    // Menampilkan form laporan
    public function index()
    {
        return view('lapor_sampah');
    }

    // Menyimpan data laporan
    public function store(Request $request)
    {
        // 1. Validasi input yang ketat
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
            'koordinat' => 'required|string',
            'c1' => 'required|integer|between:1,5',
            'c2' => 'required|integer|between:1,5',
            'c3' => 'required|integer|between:1,5',
            'c4' => 'required|integer|between:1,5',
            'c5' => 'required|integer|between:1,5',
        ]);

        try {
            DB::beginTransaction();

            // 2. Proses Upload Foto
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');

                // Membuat file unik: timestamp_nik.extension
                $filename = time() . '_' . session('user_nik') . '.' . $file->getClientOriginalExtension();

                // Simpan ke folder: storage/app/public/laporan
                $file->storeAs('public/sampah', $filename);
            }

            // 3. Simpan data ke database
            Laporan::create([
                'nik_pelapor' => session('user_nik'),
                'foto' => $filename,
                'koordinat' => $request->koordinat,
                'c1' => $request->c1,
                'c2' => $request->c2,
                'c3' => $request->c3,
                'c4' => $request->c4,
                'c5' => $request->c5,
            ]);

            DB::commit();

            return redirect()->route('lapor.index')->with('success', 'Laporan Anda berhasil dikirim dan akan segera diproses.');
        } catch (\Exception $e) {
            DB::rollback();

            // Hapuas file foto yang terlanjur di upload jika database gagal menyimpan
            if (isset($filename)) {
                Storage::delete('public/sampah/' . $filename);
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function history()
    {
        // Mengambil laporan milik user yang login berdasarkan NIK di session
        $riwayat = Laporan::where('nik_pelapor', session('user_nik'))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('riwayat_laporan', ['riwayat' => $riwayat]);
    }
}
