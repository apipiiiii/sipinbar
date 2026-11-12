@extends('layouts.admin')
@section('title', 'Tambah Barang')
@section('content')
<div class="mb-6"><h1 class="page-title">Tambah Barang</h1><p class="page-sub">Lengkapi data barang inventaris baru.</p></div>
<div class="card max-w-4xl p-5 sm:p-6">
    <form method="POST" action="{{ route('admin.barang.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.barang._form')
    </form>
</div>
@endsection
