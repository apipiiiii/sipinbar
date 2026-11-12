@extends('layouts.admin')
@section('title', 'Tambah Pengguna')
@section('content')
<div class="mb-6"><h1 class="page-title">Tambah Pengguna</h1><p class="page-sub">Buat akun admin, petugas, atau siswa.</p></div>
<div class="card max-w-4xl p-5 sm:p-6">
    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        @include('admin.users._form')
    </form>
</div>
@endsection
