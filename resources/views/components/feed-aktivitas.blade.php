@props(['feed'])
<div {{ $attributes->merge(['class' => 'card']) }}>
    <div class="card-head">
        <div>
            <h2 class="card-title">Aktivitas terbaru</h2>
            <p class="text-xs text-slate-500">Jejak proses peminjaman</p>
        </div>
    </div>
    @if(count($feed) === 0)
        <p class="px-5 py-10 text-center text-sm text-slate-400"><i class="fa-regular fa-clock mb-2 block text-2xl"></i>Belum ada aktivitas.</p>
    @else
        <ol class="px-5 py-4">
            @foreach($feed as $a)
                <li class="relative flex gap-3 {{ $loop->last ? '' : 'pb-4' }}">
                    @unless($loop->last)<span class="absolute left-[13px] top-7 h-[calc(100%-14px)] w-px bg-slate-200"></span>@endunless
                    <span class="relative inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-{{ $a['warna'] }}-50 text-{{ $a['warna'] }}-600 ring-4 ring-white"><i class="fa-solid {{ $a['ikon'] }} text-[10px]"></i></span>
                    <div class="min-w-0 pt-0.5">
                        <a href="{{ route('admin.peminjaman.show', $a['peminjaman']) }}" class="block text-sm leading-snug text-slate-600 hover:text-slate-900">
                            <b class="font-medium text-slate-900">{{ $a['pelaku'] }}</b> {{ $a['kalimat'] }}
                        </a>
                        <p class="mt-0.5 text-xs text-slate-400" title="{{ $a['waktu']->format('d M Y H:i') }}">{{ $a['waktu']->diffForHumans() }}</p>
                    </div>
                </li>
            @endforeach
        </ol>
    @endif
</div>
