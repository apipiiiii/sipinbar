{{-- Banner sambutan dashboard. Variabel: $nama (sapaan otomatis sesuai jam) atau $title, $subtitle, $actions = [[label, url, ikon, utama(bool)], ...] --}}
@php
    $jumlahNotif = count(\App\Support\Notifikasi::untuk(auth()->user()));
    $jam = (int) now()->format('G');
    $salam = $jam < 11 ? 'Selamat pagi' : ($jam < 15 ? 'Selamat siang' : ($jam < 18 ? 'Selamat sore' : 'Selamat malam'));
    $judul = $title ?? ($salam.', '.($nama ?? ''));
@endphp
<section class="mb-6 rounded-xl bg-brand-700 text-white">
    <div class="flex flex-col gap-5 p-5 sm:p-6 md:flex-row md:items-center md:justify-between">
        <div class="min-w-0">
            <h1 class="text-xl font-semibold tracking-tight sm:text-2xl">{{ $judul }}</h1>
            <p class="mt-1.5 max-w-xl text-sm leading-relaxed text-brand-100">{{ $subtitle }}</p>
            @if($jumlahNotif > 0)
                <button type="button" data-dd-toggle="sp-notif-pop" class="mt-3 inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-white transition hover:bg-white/20">
                    <i class="fa-regular fa-bell"></i> {{ $jumlahNotif }} notifikasi aktif
                </button>
            @endif
        </div>
        @if(!empty($actions))
        <div class="flex flex-wrap gap-2">
            @foreach($actions as [$label, $url, $ikon, $utama])
                <a href="{{ $url }}" class="btn {{ $utama ? 'bg-white text-brand-800 hover:bg-brand-50' : 'border border-white/25 text-white hover:bg-white/10' }}"><i class="fa-solid {{ $ikon }} text-xs"></i> {{ $label }}</a>
            @endforeach
        </div>
        @endif
    </div>
</section>
