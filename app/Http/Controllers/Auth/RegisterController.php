<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Pendaftaran akun mandiri. HANYA membuat akun dengan role "siswa".
 * Akun admin & petugas hanya dapat dibuat oleh admin lewat menu Data Pengguna.
 */
class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'nis_nip' => ['required', 'string', 'max:50', 'unique:users,nis_nip'],
            'kelas' => ['required', 'string', 'max:50'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'email.unique' => 'Email ini sudah terdaftar.',
            'nis_nip.unique' => 'NIS ini sudah terdaftar.',
            'nis_nip.required' => 'NIS wajib diisi.',
            'kelas.required' => 'Kelas wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak sama.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nis_nip' => $validated['nis_nip'],
            'kelas' => $validated['kelas'],
            'no_hp' => $validated['no_hp'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => 'siswa', // dipaksa siswa, tidak pernah dari input pengguna
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('siswa.dashboard')
            ->with('success', 'Akun berhasil dibuat. Selamat datang, '.$user->name.'!');
    }
}
