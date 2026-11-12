@extends('layouts.admin')
@section('title', 'Edit Barang')
@section('content')
<div class="mb-6"><h1 class="page-title">Ubah Data Barang</h1><p class="page-sub">Perbarui informasi barang.</p></div>
<div class="card max-w-4xl p-5 sm:p-6">
    <form method="POST" action="{{ route('admin.barang.update', $barang) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.barang._form')
    </form>
</div>
@endsection
