@props(['agenda', 'url' => null])
<div {{ $attributes->merge(['class' => 'card']) }}>
    <div class="card-head">
        <div>
            <h2 class="card-title">Jatuh tempo 7 hari ke depan</h2>
            <p class="text-xs text-slate-500">Barang yang harus kembali dalam waktu dekat</p>
        </div>
    </div>
    @if($agenda->isEmpty())
        <p class="px-5 py-9 text-center text-sm text-slate-400"><i class="fa-regular fa-calendar-check mb-2 block text-2xl"></i>Tidak ada yang jatuh tempo.</p>
    @else
        <ul class="divide-y divide-slate-100">
            @foreach($agenda as $p)
                @php
                    $tgl = $p->tanggal_kembali_rencana;
                    $hari = $tgl->isToday() ? 'Hari ini' : ($tgl->isTomorrow() ? 'Besok' : $tgl->translatedFormat('D, d M'));
                    $mendesak = $tgl->isToday() || $tgl->isTomorrow();
                @endphp
                <li class="flex items-center gap-3 px-5 py-3">
                    <span class="inline-flex h-10 w-10 shrink-0 flex-col items-center justify-center rounded-lg {{ $mendesak ? 'bg-yellow-50 text-yellow-800' : 'bg-slate-100 text-slate-600' }}">
                        <span class="text-sm font-semibold leading-none">{{ $tgl->format('d') }}</span>
                        <span class="text-[9px] font-medium uppercase leading-none mt-0.5">{{ $tgl->translatedFormat('M') }}</span>
                    </span>
                    <span class="min-w-0 flex-1">
                        <span class="block truncate text-sm font-medium text-slate-900">{{ $p->barang->nama_barang }}</span>
                        <span class="block truncate text-xs text-slate-500">{{ $p->siswa->name }}</span>
                    </span>
                    <span class="whitespace-nowrap text-xs font-medium {{ $mendesak ? 'text-yellow-700' : 'text-slate-500' }}">{{ $hari }}</span>
                </li>
            @endforeach
        </ul>
    @endif
</div>
