@extends('layouts.admin')
@section('title', 'Edit Pengguna')
@section('content')
<div class="mb-6"><h1 class="page-title">Ubah Data Pengguna</h1><p class="page-sub">Perbarui informasi akun.</p></div>
<div class="card max-w-4xl p-5 sm:p-6">
    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PUT')
        @include('admin.users._form')
    </form>
</div>
@endsection
