@extends('layouts.auth')
@section('title', 'Masuk')

@section('form')
<h2 class="text-2xl font-semibold tracking-tight text-slate-900">Masuk ke akun Anda</h2>
<p class="mt-1 mb-7 text-sm text-slate-500">Sistem Informasi Peminjaman Barang & Inventaris &mdash; SMK Negeri 5 Surakarta</p>

@if(session('success'))
    <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="mb-5 space-y-0.5 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
        @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
    </div>
@endif

<form method="POST" action="{{ route('login') }}" class="space-y-4">
    @csrf
    <div>
        <label class="label" for="email">Email</label>
        <div class="relative">
            <i class="fa-solid fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400"></i>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@sipinbar.sch.id" class="input pl-9">
        </div>
    </div>
    <div>
        <label class="label" for="password">Kata Sandi</label>
        <div class="relative">
            <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400"></i>
            <input id="password" type="password" name="password" required placeholder="Masukkan kata sandi" class="input pl-9 pr-10">
            <button type="button" onclick="var i=document.getElementById('password');var h=i.type==='password';i.type=h?'text':'password';this.firstElementChild.className=h?'fa-regular fa-eye-slash':'fa-regular fa-eye'" class="absolute right-2 top-1/2 inline-flex h-7 w-7 -translate-y-1/2 items-center justify-center rounded-md text-slate-400 hover:text-slate-700" aria-label="Tampilkan kata sandi"><i class="fa-regular fa-eye"></i></button>
        </div>
    </div>
    <label class="flex cursor-pointer items-center gap-2 text-sm text-slate-600">
        <input type="checkbox" name="remember" class="rounded border-slate-300 text-brand-600 focus:ring-brand-500/30"> Ingat saya
    </label>
    <button type="submit" class="btn btn-primary w-full py-2.5"><i class="fa-solid fa-right-to-bracket"></i> Masuk</button>
</form>

<p class="mt-5 text-center text-sm text-slate-500">Siswa belum punya akun? <a href="{{ route('register') }}" class="link">Daftar sekarang</a></p>

<div class="mt-6 rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-xs leading-relaxed text-slate-500">
    <p class="mb-1 font-semibold text-slate-600">Akun demo</p>
    Admin: admin@sipinbar.sch.id / admin123<br>
    Petugas: petugas.lab@sipinbar.sch.id / petugas123<br>
    Siswa: rafif.bari@siswa.sipinbar.sch.id / siswa123
</div>
@endsection
