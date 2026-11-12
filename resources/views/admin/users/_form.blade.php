@php $u = $user ?? null; @endphp
<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <div>
        <label class="label">Nama Lengkap</label>
        <input type="text" name="name" value="{{ old('name', $u->name ?? '') }}" required
               class="input">
    </div>
    <div>
        <label class="label">Email</label>
        <input type="email" name="email" value="{{ old('email', $u->email ?? '') }}" required
               class="input">
    </div>
    <div>
        <label class="label">Role</label>
        <select name="role" required
                class="input">
            <option value="siswa" @selected(old('role', $u->role ?? '') == 'siswa')>Siswa</option>
            <option value="petugas" @selected(old('role', $u->role ?? '') == 'petugas')>Petugas (konfirmasi penyerahan/pengembalian)</option>
            <option value="admin" @selected(old('role', $u->role ?? '') == 'admin')>Admin</option>
        </select>
    </div>
    <div>
        <label class="label">NIS / NIP</label>
        <input type="text" name="nis_nip" value="{{ old('nis_nip', $u->nis_nip ?? '') }}"
               class="input">
    </div>
    <div>
        <label class="label">Kelas (khusus siswa)</label>
        <input type="text" name="kelas" value="{{ old('kelas', $u->kelas ?? '') }}" placeholder="Contoh: XII RPL B"
               class="input">
    </div>
    <div>
        <label class="label">No. HP</label>
        <input type="text" name="no_hp" value="{{ old('no_hp', $u->no_hp ?? '') }}"
               class="input">
    </div>
    <div>
        <label class="label">{{ $u ? 'Kata Sandi Baru (opsional)' : 'Kata Sandi' }}</label>
        <input type="password" name="password" {{ $u ? '' : 'required' }} minlength="6"
               class="input">
    </div>
    <div class="md:col-span-2">
        <label class="label">Alamat</label>
        <textarea name="alamat" rows="2"
                  class="input">{{ old('alamat', $u->alamat ?? '') }}</textarea>
    </div>
</div>
<div class="mt-6 flex items-center gap-3">
    <button class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Batal</a>
</div>
