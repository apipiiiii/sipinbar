@extends('layouts.admin')
@section('title', 'Tambah Kategori')
@section('content')
<div class="mb-6"><h1 class="page-title">Tambah Kategori</h1><p class="page-sub">Kelompokkan barang dan tetapkan petugas penanggung jawab.</p></div>
<div class="grid max-w-5xl grid-cols-1 gap-5 lg:grid-cols-[minmax(0,2fr)_minmax(0,1fr)]">
<div class="card p-5 sm:p-6">
    <form method="POST" action="{{ route('admin.kategori.store') }}">
        @csrf
        @include('admin.kategori._form')
    </form>
</div>
    <aside class="card h-fit p-5">
        <h2 class="card-title mb-3">Alur peminjaman per kategori</h2>
        <ol class="space-y-3 text-sm text-slate-600">
            <li class="flex gap-3"><span class="mt-0.5 inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-brand-50 text-[11px] font-semibold text-brand-700">1</span> Siswa mengajukan peminjaman barang.</li>
            <li class="flex gap-3"><span class="mt-0.5 inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-brand-50 text-[11px] font-semibold text-brand-700">2</span> Admin memverifikasi pengajuan.</li>
            <li class="flex gap-3"><span class="mt-0.5 inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-brand-50 text-[11px] font-semibold text-brand-700">3</span> <span><b class="font-medium text-slate-800">Petugas kategori</b> menyerahkan barang ke siswa dan menerima pengembaliannya.</span></li>
            <li class="flex gap-3"><span class="mt-0.5 inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-brand-50 text-[11px] font-semibold text-brand-700">4</span> Admin mengonfirmasi pengembalian dan stok bertambah kembali.</li>
        </ol>
        <p class="mt-4 border-t border-slate-100 pt-3 text-xs text-slate-500">Akun petugas dibuat di menu Data Pengguna dengan role Petugas.</p>
    </aside>
</div>
@endsection
