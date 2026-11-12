@props(['color' => 'secondary', 'label' => '', 'dark' => false])
@php
    // Satu gaya terang untuk semua role. Parameter "dark" dipertahankan agar pemanggilan lama tetap valid.
    $map = [
        'warning'   => 'bg-yellow-50 text-yellow-800 ring-yellow-600/20',
        'primary'   => 'bg-brand-50 text-brand-700 ring-brand-600/20',
        'danger'    => 'bg-rose-50 text-rose-700 ring-rose-600/20',
        'success'   => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
        'secondary' => 'bg-slate-100 text-slate-600 ring-slate-500/20',
        'dark'      => 'bg-slate-100 text-slate-700 ring-slate-500/30',
        'info'      => 'bg-sky-50 text-sky-700 ring-sky-600/20',
    ];
    $classes = $map[$color] ?? $map['secondary'];
@endphp
<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-medium ring-1 ring-inset whitespace-nowrap $classes"]) }}>
    <span class="h-1.5 w-1.5 rounded-full bg-current"></span>{{ $label }}
</span>
