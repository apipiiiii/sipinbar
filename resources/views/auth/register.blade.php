@extends('layouts.auth')
@section('title', 'Daftar')

@section('form')
<h2 class="text-2xl font-semibold tracking-tight text-slate-900">Daftar akun siswa</h2>
<p class="mt-1 mb-6 text-sm text-slate-500">Buat akun untuk meminjam barang inventaris sekolah. Pendaftaran ini khusus untuk siswa.</p>

@if($errors->any())
    <div class="mb-5 space-y-0.5 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
        @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
    </div>
@endif

<form method="POST" action="{{ route('register') }}" class="space-y-4">
    @csrf
    <div>
        <label class="label">Nama Lengkap</label>
        <input type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Nama sesuai data sekolah" class="input">
    </div>
    <div>
        <label class="label">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com" class="input">
    </div>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
            <label class="label">NIS</label>
            <input type="text" name="nis_nip" value="{{ old('nis_nip') }}" required placeholder="Nomor Induk Siswa" class="input">
        </div>
        <div>
            <label class="label">Kelas</label>
            <input type="text" name="kelas" value="{{ old('kelas') }}" required placeholder="Contoh: XII RPL B" class="input">
        </div>
    </div>
    <div>
        <label class="label">No. HP <span class="font-normal text-slate-400">(opsional)</span></label>
        <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx" class="input">
    </div>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
            <label class="label">Kata Sandi</label>
            <input type="password" name="password" required minlength="6" placeholder="Minimal 6 karakter" class="input">
        </div>
        <div>
            <label class="label">Konfirmasi Kata Sandi</label>
            <input type="password" name="password_confirmation" required minlength="6" placeholder="Ulangi kata sandi" class="input">
        </div>
    </div>
    <button type="submit" class="btn btn-primary w-full py-2.5"><i class="fa-solid fa-user-plus"></i> Daftar</button>
</form>

<p class="mt-6 text-center text-sm text-slate-500">Sudah punya akun? <a href="{{ route('login') }}" class="link">Masuk</a></p>
@endsection
