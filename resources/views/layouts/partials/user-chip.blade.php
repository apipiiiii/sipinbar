<div class="flex items-center gap-2.5">
    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-brand-100 text-xs font-semibold text-brand-700">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</span>
    <div class="hidden sm:block leading-tight min-w-0">
        <p class="text-sm font-medium text-slate-900 truncate max-w-[160px]">{{ auth()->user()->name }}</p>
        <p class="text-[11px] text-slate-500">{{ $roleLabel }}</p>
    </div>
</div>
