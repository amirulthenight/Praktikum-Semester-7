<?php

namespace App\Http\Controllers;

use App\Models\Masyarakat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MasyarakatController extends Controller
{
    public function index()
    {
        return view('registrasi');
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $validatedData = $request->validate([
            'nik' => 'required|numeric|digits:16|unique:masyarakats,nik',
            'nama' => 'required|string|max:255',
            'telp' => 'required|numeric|digits_between:10,15',
            'email' => 'required|email|unique:masyarakats,email',
            'alamat' => 'required|string|min:10',
        ], [
            // Custom pesan error bahasa indo
            'nik.unique' => 'NIK ini sudah terdaftar!',
            'nik.digits' => 'NIK harus terdiri dari 16 digit angka.',
            'email.unique' => 'Email ini sudah digunakan.',
            'required' => ':attribute wajib diisi.',
        ]);

        // 2. Simpan Data ke Database
        Masyarakat::create($validatedData);
        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // validasi input
        $request->validate([
            'nik' => 'required|numeric|digits:16',
            'email' => 'required|email'
        ]);

        // 2. Cek apakah NIK dan Email cocok di database
        $user = Masyarakat::where('nik', $request->nik)
            ->where('email', $request->email)
            ->first();

        if ($user) {
            // 3. Jika cocok, simpan data ke session
            session([
                'login_masyarakat' => true,
                'user_id' => $user->id,
                'user_nik' => $user->nik,
                'user_nama' => $user->nama
            ]);

            // Langsung redirect ke halaman lapor sampah (nanti kita buat view-nya)
            return redirect()->route('lapor.index')->with('success', 'Selamat Datang, ' . $user->nama);
        }

        // Jika gagal
        return redirect()->back()->with('error', 'NIK atau Email tidak ditemukan dalam sistem kami.');
    }

    public function logout()
    {
        session()->forget(['login_masyarakat', 'user_id', 'user_nik', 'user_nama']);
        return redirect()->route('login')->with('success', 'Anda telah keluar.');
    }
}
