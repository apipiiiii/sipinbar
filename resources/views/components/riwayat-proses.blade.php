@props(['p'])
@php
    use Carbon\Carbon;

    $t = fn ($v) => $v ? Carbon::parse($v) : null;
    $kejadian = collect([
        ['Pengajuan dibuat', $t($p->created_at), optional($p->siswa)->name],
        ['Diverifikasi admin', $t($p->tanggal_verifikasi), optional($p->verifikator)->name],
        ['Barang diserahkan', $t($p->tanggal_diserahkan), optional($p->petugasPenyerah)->name],
        ['Pengembalian diajukan', $t($p->tanggal_pengembalian_diajukan), optional($p->siswa)->name],
        ['Diterima petugas', $t($p->tanggal_diterima_petugas), optional($p->petugasPenerima)->name],
        ['Dikonfirmasi admin', $t($p->tanggal_konfirmasi_kembali), null],
    ])->filter(fn ($e) => $e[1])->values();
@endphp
<div {{ $attributes->merge(['class' => 'card h-fit']) }}>
    <div class="card-head"><h2 class="card-title">Riwayat proses</h2></div>
    <ol class="p-5">
        @foreach($kejadian as $i => [$judul, $waktu, $oleh])
            <li class="relative flex gap-3 {{ $loop->last ? '' : 'pb-5' }}">
                @unless($loop->last)<span class="absolute left-[7px] top-4 h-full w-px bg-slate-200"></span>@endunless
                <span class="relative mt-1 h-[15px] w-[15px] shrink-0 rounded-full border-2 {{ $loop->last ? 'border-brand-600 bg-brand-600' : 'border-brand-300 bg-white' }}"></span>
                <div class="min-w-0">
                    <p class="text-sm font-medium text-slate-900">{{ $judul }}</p>
                    <p class="text-xs text-slate-500">{{ $waktu->format('d M Y, H:i') }}@if($oleh) &middot; {{ $oleh }}@endif</p>
                </div>
            </li>
        @endforeach
    </ol>
</div>
