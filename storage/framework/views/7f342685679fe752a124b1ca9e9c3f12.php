<?php $notif = \App\Support\Notifikasi::untuk(auth()->user()); ?>
<div class="relative">
    <button type="button" data-dd-toggle="sp-notif-pop" id="sp-notif-btn" aria-label="Notifikasi"
            class="relative inline-flex h-9 w-9 items-center justify-center rounded-lg text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">
        <i id="sp-notif-icon" class="fa-regular fa-bell text-[15px]"></i>
        <span id="sp-notif-badge" class="absolute -right-0.5 -top-0.5 hidden min-w-[18px] rounded-full bg-rose-600 px-1 text-center text-[10px] font-bold leading-[18px] text-white ring-2 ring-white"></span>
    </button>

    <div id="sp-notif-pop" class="fixed inset-x-3 top-16 z-50 hidden overflow-hidden rounded-xl border border-slate-200 bg-white shadow-pop sm:absolute sm:inset-x-auto sm:right-0 sm:top-full sm:mt-2 sm:w-[390px]">
        <div class="flex items-center justify-between border-b border-slate-100 px-4 py-3">
            <div>
                <p class="text-sm font-semibold text-slate-900">Notifikasi</p>
                <p class="text-xs text-slate-500" id="sp-notif-sub"></p>
            </div>
            <button type="button" id="sp-notif-readall" class="hidden text-xs font-medium text-brand-700 hover:underline">Tandai semua dibaca</button>
        </div>
        <ul id="sp-notif-list" class="max-h-[min(420px,calc(100vh-9rem))] divide-y divide-slate-100 overflow-y-auto"></ul>
        <div id="sp-notif-empty" class="hidden px-6 py-10 text-center">
            <span class="mx-auto mb-3 inline-flex h-10 w-10 items-center justify-center rounded-full bg-emerald-50 text-emerald-600"><i class="fa-solid fa-check"></i></span>
            <p class="text-sm font-medium text-slate-900">Semua beres</p>
            <p class="mt-0.5 text-xs text-slate-500">Tidak ada peringatan saat ini.</p>
        </div>
    </div>
</div>

<script>
    (function () {
        var storeKey = 'sp_notif_seen_<?php echo e((int) auth()->id()); ?>';
        var url = <?php echo json_encode(route('notifikasi.index'), 15, 512) ?>;
        var items = <?php echo json_encode($notif, 15, 512) ?>;
        var seen = [];
        try { seen = JSON.parse(localStorage.getItem(storeKey) || '[]'); } catch (e) {}

        var list = document.getElementById('sp-notif-list');
        var badge = document.getElementById('sp-notif-badge');
        var sub = document.getElementById('sp-notif-sub');
        var empty = document.getElementById('sp-notif-empty');
        var readAll = document.getElementById('sp-notif-readall');
        var icon = document.getElementById('sp-notif-icon');
        var tone = { danger: 'bg-rose-50 text-rose-600', warning: 'bg-yellow-50 text-yellow-600', info: 'bg-brand-50 text-brand-600' };

        function esc(t) { return String(t).replace(/[&<>"']/g, function (c) { return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]; }); }
        function save() { try { localStorage.setItem(storeKey, JSON.stringify(seen)); } catch (e) {} }
        function keys() { return items.map(function (i) { return i.key; }); }
        function unreadCount() { return items.filter(function (i) { return seen.indexOf(i.key) === -1; }).length; }
        function wiggle() {
            icon.classList.remove('sp-wiggle'); void icon.offsetWidth; icon.classList.add('sp-wiggle');
            icon.addEventListener('animationend', function f() { icon.classList.remove('sp-wiggle'); icon.removeEventListener('animationend', f); });
        }

        function render() {
            seen = seen.filter(function (k) { return keys().indexOf(k) !== -1; });
            list.innerHTML = items.map(function (n) {
                var baru = seen.indexOf(n.key) === -1;
                return '<li><a href="' + esc(n.url) + '" data-notif-key="' + esc(n.key) + '" class="group flex gap-3 px-4 py-3 transition hover:bg-slate-50 ' + (baru ? 'bg-brand-50/40' : '') + '">' +
                    '<span class="mt-0.5 inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg ' + (tone[n.level] || tone.info) + '"><i class="fa-solid ' + esc(n.icon) + ' text-xs"></i></span>' +
                    '<span class="min-w-0 flex-1"><span class="flex items-start justify-between gap-2"><span class="text-sm font-medium leading-snug text-slate-900">' + esc(n.title) + '</span>' +
                    (baru ? '<span class="mt-1.5 h-2 w-2 shrink-0 rounded-full bg-brand-600"></span>' : '') + '</span>' +
                    '<span class="mt-0.5 block text-xs leading-relaxed text-slate-500">' + esc(n.message) + '</span></span></a></li>';
            }).join('');
            var u = unreadCount();
            badge.textContent = u > 9 ? '9+' : u;
            badge.classList.toggle('hidden', u === 0);
            empty.classList.toggle('hidden', items.length > 0);
            readAll.classList.toggle('hidden', items.length === 0 || u === 0);
            sub.textContent = items.length ? (u ? u + ' belum dibaca · ' + items.length + ' aktif' : 'Semua sudah dibaca · ' + items.length + ' aktif') : 'Tidak ada peringatan';
        }

        list.addEventListener('click', function (e) {
            var a = e.target.closest('[data-notif-key]'); if (!a) return;
            var k = a.getAttribute('data-notif-key');
            if (seen.indexOf(k) === -1) { seen.push(k); save(); }
        });
        readAll.addEventListener('click', function () { seen = keys(); save(); render(); });

        /* Cek notifikasi baru tiap 60 detik (berhenti saat tab tidak aktif). */
        function cek() {
            if (document.hidden) return;
            fetch(url, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, credentials: 'same-origin' })
                .then(function (r) { return r.ok ? r.json() : null; })
                .then(function (d) {
                    if (!d || !Array.isArray(d.items)) return;
                    var lama = keys();
                    items = d.items;
                    var baru = items.filter(function (i) { return lama.indexOf(i.key) === -1 && seen.indexOf(i.key) === -1; });
                    render();
                    if (baru.length) {
                        wiggle();
                        baru.slice(0, 2).forEach(function (n) { if (window.SP_toast) SP_toast(n.title, n.level === 'danger' ? 'error' : (n.level === 'warning' ? 'warning' : 'info'), n.message, n.url); });
                    }
                }).catch(function () {});
        }
        setInterval(cek, 60000);
        document.addEventListener('visibilitychange', function () { if (!document.hidden) cek(); });

        render();
        if (unreadCount() > 0) setTimeout(wiggle, 700);
    })();
</script>
<?php /**PATH C:\xampp\htdocs\sipinbar-laravel_FINAL_petugas_v6_3\sipinbar-laravel_neww\resources\views/layouts/partials/notif.blade.php ENDPATH**/ ?>