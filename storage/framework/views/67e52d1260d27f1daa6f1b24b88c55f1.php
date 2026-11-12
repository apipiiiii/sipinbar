
<div id="sp-palette" class="fixed inset-0 z-[70] hidden" role="dialog" aria-modal="true" aria-label="Cari menu">
    <div class="absolute inset-0 bg-slate-900/40" data-palette-close></div>
    <div class="relative mx-auto mt-[12vh] w-[calc(100vw-2rem)] max-w-lg overflow-hidden rounded-xl border border-slate-200 bg-white shadow-pop">
        <div class="flex items-center gap-3 border-b border-slate-100 px-4">
            <i class="fa-solid fa-magnifying-glass text-sm text-slate-400"></i>
            <input id="sp-palette-input" type="text" autocomplete="off" placeholder="Cari halaman atau aksi..." class="h-12 flex-1 bg-transparent text-sm text-slate-900 outline-none placeholder:text-slate-400">
            <kbd class="rounded border border-slate-200 px-1.5 py-0.5 text-[10px] font-medium text-slate-400">Esc</kbd>
        </div>
        <ul id="sp-palette-list" class="max-h-[50vh] overflow-y-auto p-2"></ul>
        <p id="sp-palette-empty" class="hidden px-4 py-8 text-center text-sm text-slate-400">Tidak ada hasil.</p>
        <div class="flex items-center gap-4 border-t border-slate-100 bg-slate-50 px-4 py-2 text-[11px] text-slate-500">
            <span><kbd class="rounded border border-slate-200 bg-white px-1">↑</kbd> <kbd class="rounded border border-slate-200 bg-white px-1">↓</kbd> pilih</span>
            <span><kbd class="rounded border border-slate-200 bg-white px-1">Enter</kbd> buka</span>
        </div>
    </div>
</div>
<script>
    (function () {
        var items = <?php echo json_encode($paletteItems, 15, 512) ?>;
        var root = document.getElementById('sp-palette');
        var input = document.getElementById('sp-palette-input');
        var list = document.getElementById('sp-palette-list');
        var empty = document.getElementById('sp-palette-empty');
        var aktif = 0, tampil = [];

        function esc(t) { return String(t).replace(/[&<>"]/g, function (c) { return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]; }); }
        function gambar() {
            var q = input.value.trim().toLowerCase();
            tampil = items.filter(function (i) { return !q || (i[0] + ' ' + i[3]).toLowerCase().indexOf(q) !== -1; });
            if (aktif >= tampil.length) aktif = 0;
            var grup = '', html = '';
            tampil.forEach(function (i, idx) {
                if (i[3] !== grup) { grup = i[3]; html += '<li class="px-3 pb-1 pt-2 text-[11px] font-semibold uppercase tracking-wider text-slate-400">' + esc(grup) + '</li>'; }
                html += '<li><a href="' + esc(i[1]) + '" data-idx="' + idx + '" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm ' + (idx === aktif ? 'bg-brand-50 text-brand-800' : 'text-slate-700 hover:bg-slate-50') + '">' +
                        '<i class="fa-solid ' + esc(i[2]) + ' w-4 text-center text-xs ' + (idx === aktif ? 'text-brand-600' : 'text-slate-400') + '"></i>' + esc(i[0]) + '</a></li>';
            });
            list.innerHTML = html;
            empty.classList.toggle('hidden', tampil.length > 0);
            var el = list.querySelector('[data-idx="' + aktif + '"]'); if (el) el.scrollIntoView({ block: 'nearest' });
        }
        function buka() { root.classList.remove('hidden'); input.value = ''; aktif = 0; gambar(); setTimeout(function () { input.focus(); }, 10); }
        function tutup() { root.classList.add('hidden'); }

        document.addEventListener('click', function (e) {
            if (e.target.closest('[data-palette-open]')) { e.preventDefault(); buka(); }
            else if (e.target.closest('[data-palette-close]')) tutup();
        });
        document.addEventListener('keydown', function (e) {
            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') { e.preventDefault(); root.classList.contains('hidden') ? buka() : tutup(); return; }
            if (root.classList.contains('hidden')) return;
            if (e.key === 'Escape') tutup();
            else if (e.key === 'ArrowDown') { e.preventDefault(); aktif = Math.min(aktif + 1, tampil.length - 1); gambar(); }
            else if (e.key === 'ArrowUp') { e.preventDefault(); aktif = Math.max(aktif - 1, 0); gambar(); }
            else if (e.key === 'Enter' && tampil[aktif]) { e.preventDefault(); window.location.href = tampil[aktif][1]; }
        });
        input.addEventListener('input', function () { aktif = 0; gambar(); });
    })();
</script>
<?php /**PATH C:\Users\user\Downloads\sipinbar-laravel_FINAL_petugas_v6_3\sipinbar-laravel_neww\resources\views/layouts/partials/palette.blade.php ENDPATH**/ ?>