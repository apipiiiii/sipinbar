@php $b = $barang ?? null; @endphp
<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <div>
        <label class="label">Kode Barang</label>
        <input type="text" name="kode_barang" value="{{ old('kode_barang', $b->kode_barang ?? '') }}" required
               class="input">
    </div>
    <div>
        <label class="label">Nama Barang</label>
        <input type="text" name="nama_barang" value="{{ old('nama_barang', $b->nama_barang ?? '') }}" required
               class="input">
    </div>
    <div>
        <label class="label">Kategori</label>
        <select name="kategori_barang_id" required
                class="input">
            <option value="">-- Pilih Kategori --</option>
            @foreach($kategoriList as $k)
                <option value="{{ $k->id }}" class="bg-white" @selected(old('kategori_barang_id', $b->kategori_barang_id ?? '') == $k->id)>{{ $k->nama_kategori }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="label">Stok Total</label>
        <input type="number" min="0" name="stok_total" value="{{ old('stok_total', $b->stok_total ?? 0) }}" required
               class="input">
        @if($b)
            <p class="text-xs text-slate-500 mt-1.5">Stok tersedia saat ini: {{ $b->stok_tersedia }}. Menaikkan/menurunkan stok total akan otomatis menyesuaikan stok tersedia.</p>
        @endif
    </div>
    <div>
        <label class="label">Kondisi</label>
        <select name="kondisi" required
                class="input">
            @foreach(['baik' => 'Baik', 'rusak ringan' => 'Rusak Ringan', 'rusak berat' => 'Rusak Berat'] as $val => $label)
                <option value="{{ $val }}" @selected(old('kondisi', $b->kondisi ?? 'baik') == $val)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="label">Foto Barang (opsional)</label>
        <input type="file" name="foto" accept="image/*"
               class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-brand-50 file:text-brand-700 file:px-3 file:py-1.5 file:text-xs file:font-semibold">
        @if($b?->foto)
            <img src="{{ asset('storage/'.$b->foto) }}" class="mt-2.5 rounded-xl h-16 ring-1 ring-slate-200">
        @endif
    </div>
    <div class="md:col-span-2">
        <label class="label">Deskripsi</label>
        <textarea name="deskripsi" rows="3"
                  class="input">{{ old('deskripsi', $b->deskripsi ?? '') }}</textarea>
    </div>
</div>
<div class="mt-6 flex items-center gap-3">
    <button class="btn btn-primary">
        <i class="fa-solid fa-floppy-disk"></i> Simpan
    </button>
    <a href="{{ route('admin.barang.index') }}" class="btn btn-outline">Batal</a>
</div>
