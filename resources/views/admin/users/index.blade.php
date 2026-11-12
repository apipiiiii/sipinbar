@extends('layouts.admin')
@section('title', 'Data Pengguna')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div><h1 class="page-title">Data Pengguna</h1><p class="page-sub">Kelola akun admin, petugas, dan siswa.</p></div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> Tambah Pengguna
    </a>
</div>

<div class="card p-4 mb-5">
    <form class="grid grid-cols-1 md:grid-cols-[1fr_auto_auto] gap-3 items-end">
        <div>
            <label class="label">Cari (nama/email/NIS-NIP)</label>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Ketik untuk mencari..."
                   class="input">
        </div>
        <div>
            <label class="label">Role</label>
            <select name="role" class="input">
                <option value="">Semua Role</option>
                <option value="admin" @selected(request('role')=='admin')>Admin</option>
                <option value="petugas" @selected(request('role')=='petugas')>Petugas</option>
                <option value="siswa" @selected(request('role')=='siswa')>Siswa</option>
            </select>
        </div>
        <button class="btn btn-outline"><i class="fa-solid fa-filter"></i> Filter</button>
    </form>
</div>

<div class="card">
    <div class="overflow-x-auto">
        <table class="tbl">
            <thead>
                <tr>
                    <th>Nama</th><th>Email</th><th>Role</th><th>NIS/NIP</th><th>Kelas</th><th>No. HP</th><th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse($users as $user)
                <tr class="hover:bg-slate-50 transition">
                    <td class="font-medium text-slate-800">{{ $user->name }}</td>
                    <td class="text-slate-500">{{ $user->email }}</td>
                    <td>
                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {{ $user->isAdmin() ? 'bg-brand-50 text-brand-700 ring-brand-200' : ($user->isPetugas() ? 'bg-yellow-50 text-yellow-700 ring-yellow-200' : 'bg-brand-50 text-brand-700 ring-brand-200') }}">{{ $user->labelRole() }}</span>
                    </td>
                    <td class="text-slate-500">{{ $user->nis_nip ?? '-' }}</td>
                    <td class="text-slate-500">{{ $user->kelas ?? '-' }}</td>
                    <td class="text-slate-500">{{ $user->no_hp ?? '-' }}</td>
                    <td class="text-right">
                        <div class="inline-flex items-center gap-1.5">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline btn-icon" title="Ubah"><i class="fa-solid fa-pen text-xs"></i></a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pengguna ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-icon" title="Hapus"><i class="fa-solid fa-trash text-xs"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="!py-12 text-center text-slate-400"><i class="fa-regular fa-folder-open mb-2 block text-2xl"></i>Belum ada data pengguna.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-5 border-t border-slate-200">{{ $users->links() }}</div>
</div>
@endsection
