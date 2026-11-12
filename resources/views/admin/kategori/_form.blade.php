@php $k = $kategori ?? null; @endphp
<div class="mb-5">
    <label class="label">Nama Kategori</label>
    <input type="text" name="nama_kategori" value="{{ old('nama_kategori', $k->nama_kategori ?? '') }}" required
           class="input">
</div>
<div class="mb-5">
    <label class="label">Keterangan</label>
    <textarea name="keterangan" rows="3"
              class="input">{{ old('keterangan', $k->keterangan ?? '') }}</textarea>
</div>
<div class="mb-5">
    <label class="label">Petugas Penanggung Jawab</label>
    <select name="petugas_id"
            class="input">
        <option value="">&mdash; Belum ada petugas &mdash;</option>
        @foreach(($petugasList ?? []) as $pt)
            <option value="{{ $pt->id }}" class="bg-white" @selected((string) old('petugas_id', $k->petugas_id ?? '') === (string) $pt->id)>{{ $pt->name }} ({{ $pt->email }})</option>
        @endforeach
    </select>
    <p class="text-xs text-slate-500 mt-1.5">Petugas ini yang mengonfirmasi penyerahan & penerimaan barang pada kategori ini.</p>
</div>
<div class="flex items-center gap-3">
    <button class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
    <a href="{{ route('admin.kategori.index') }}" class="btn btn-outline">Batal</a>
</div>
