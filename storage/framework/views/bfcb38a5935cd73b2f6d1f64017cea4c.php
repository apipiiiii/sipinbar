<!DOCTYPE html>
<html lang="id">
<head>
    <?php echo $__env->make('layouts.partials.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>
<body class="min-h-screen">
<?php echo $__env->yieldContent('shell'); ?>

<?php echo $__env->yieldPushContent('vendor'); ?>
<script>
    /* Dropdown sederhana: tombol [data-dd-toggle="id"] membuka/menutup elemen #id; klik di luar / Esc menutup. */
    (function () {
        function tutupSemua(kecuali) {
            document.querySelectorAll('[data-dd-open]').forEach(function (el) {
                if (el !== kecuali) { el.classList.add('hidden'); el.removeAttribute('data-dd-open'); }
            });
        }
        document.addEventListener('click', function (e) {
            var tombol = e.target.closest('[data-dd-toggle]');
            if (tombol) {
                var target = document.getElementById(tombol.getAttribute('data-dd-toggle'));
                var buka = target.classList.contains('hidden');
                tutupSemua(buka ? target : null);
                target.classList.toggle('hidden', !buka);
                if (buka) target.setAttribute('data-dd-open', ''); else target.removeAttribute('data-dd-open');
                return;
            }
            if (!e.target.closest('[data-dd-open]')) tutupSemua(null);
        });
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape') tutupSemua(null); });
    })();
</script>
<script>
    /* ---- Toast (dipakai pesan sistem & notifikasi baru) ---- */
    window.SP_toast = function (judul, tipe, pesan, url) {
        var cfg = { success: ['emerald', 'fa-circle-check'], error: ['rose', 'fa-circle-exclamation'], warning: ['yellow', 'fa-triangle-exclamation'], info: ['brand', 'fa-bell'] }[tipe || 'info'];
        var box = document.getElementById('sp-toasts');
        if (!box) {
            box = document.createElement('div'); box.id = 'sp-toasts';
            box.className = 'pointer-events-none fixed right-4 top-16 z-[60] flex w-[calc(100vw-2rem)] max-w-sm flex-col gap-2';
            document.body.appendChild(box);
        }
        function e(t) { return String(t).replace(/[&<>"]/g, function (c) { return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]; }); }
        var el = document.createElement('div');
        el.setAttribute('data-toast', ''); el.setAttribute('role', 'status');
        el.className = 'pointer-events-auto flex items-start gap-3 rounded-xl border border-slate-200 bg-white p-3.5 shadow-pop';
        el.innerHTML = '<span class="inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-' + cfg[0] + '-50 text-' + cfg[0] + '-600"><i class="fa-solid ' + cfg[1] + ' text-xs"></i></span>' +
            '<div class="min-w-0 flex-1 pt-0.5"><p class="text-sm font-medium text-slate-800">' + e(judul) + '</p>' + (pesan ? '<p class="mt-0.5 text-xs text-slate-500">' + e(pesan) + '</p>' : '') +
            (url ? '<a href="' + e(url) + '" class="mt-1 inline-block text-xs font-medium text-brand-700 hover:underline">Lihat</a>' : '') + '</div>' +
            '<button type="button" class="text-slate-400 hover:text-slate-600" aria-label="Tutup"><i class="fa-solid fa-xmark text-xs"></i></button>';
        el.querySelector('button').addEventListener('click', function () { el.remove(); });
        box.appendChild(el);
        setTimeout(function () { tutup(el); }, 6000);
    };
    function tutup(t) {
        if (!t.isConnected) return;
        t.style.transition = 'opacity .3s, transform .3s'; t.style.opacity = 0; t.style.transform = 'translateY(-6px)';
        setTimeout(function () { t.remove(); }, 320);
    }
    setTimeout(function () { document.querySelectorAll('#sp-toasts [data-toast]').forEach(tutup); }, 5000);

    /* ---- Confetti kecil (tanpa pustaka) ---- */
    window.SP_confetti = function () {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
        var cv = document.createElement('canvas');
        cv.style.cssText = 'position:fixed;inset:0;width:100%;height:100%;pointer-events:none;z-index:80';
        document.body.appendChild(cv);
        var w = cv.width = innerWidth, h = cv.height = innerHeight, ctx = cv.getContext('2d');
        var root = getComputedStyle(document.documentElement);
        function rgb(n) { return 'rgb(' + root.getPropertyValue('--b' + n).trim().split(/\s+/).join(',') + ')'; }
        var warna = [rgb(400), rgb(500), rgb(600), rgb(300), '#059669', '#CA8A04', '#E11D48'];
        var p = [];
        for (var i = 0; i < 90; i++) p.push({ x: w / 2 + (Math.random() - .5) * 160, y: h * .25, vx: (Math.random() - .5) * 11, vy: -Math.random() * 9 - 2, s: 5 + Math.random() * 6, r: Math.random() * 6, vr: (Math.random() - .5) * .4, c: warna[i % warna.length] });
        var t0 = null;
        (function loop(t) {
            if (t0 === null) t0 = t;
            var umur = (t - t0) / 1900;
            ctx.clearRect(0, 0, w, h);
            p.forEach(function (q) {
                q.vy += .32; q.x += q.vx; q.y += q.vy; q.vx *= .99; q.r += q.vr;
                ctx.save(); ctx.globalAlpha = Math.max(0, 1 - umur * .9); ctx.translate(q.x, q.y); ctx.rotate(q.r);
                ctx.fillStyle = q.c; ctx.fillRect(-q.s / 2, -q.s / 4, q.s, q.s / 2); ctx.restore();
            });
            if (umur < 1) requestAnimationFrame(loop); else cv.remove();
        })(performance.now());
    };
    if (document.querySelector('[data-confetti]')) setTimeout(SP_confetti, 250);

    /* Angka ringkasan (.kpi-value) naik dari 0 saat halaman dimuat. */
    (function () {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
        document.querySelectorAll('.kpi-value').forEach(function (el) {
            if (el.children.length) return;
            var teks = el.textContent.trim();
            if (!/^\d+$/.test(teks)) return;
            var akhir = parseInt(teks, 10); if (akhir < 2) return;
            var mulai = null, dur = 600;
            function langkah(t) {
                if (mulai === null) mulai = t;
                var p = Math.min((t - mulai) / dur, 1);
                el.textContent = Math.round(akhir * (1 - Math.pow(1 - p, 3)));
                if (p < 1) requestAnimationFrame(langkah); else el.textContent = akhir;
            }
            el.textContent = '0';
            requestAnimationFrame(langkah);
        });
    })();

    /* Cegah kirim ganda: tombol submit jadi "memproses" setelah form dikirim. */
    (function () {
        document.addEventListener('submit', function (e) {
            if (e.defaultPrevented || /logout/.test(e.target.action || '')) return;
            var btn = e.submitter || e.target.querySelector('button:not([type]), button[type=submit]');
            if (!btn || btn.disabled) return;
            setTimeout(function () {
                btn.dataset.html = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Memproses...';
            }, 0);
        });
        window.addEventListener('pageshow', function (e) {
            if (!e.persisted) return;
            document.querySelectorAll('button[data-html]').forEach(function (b) { b.disabled = false; b.innerHTML = b.dataset.html; });
        });
    })();
</script>
<?php echo $__env->make('layouts.partials.table-enhance', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\sipinbar-laravel_FINAL_petugas_v6_3\sipinbar-laravel_neww\resources\views/layouts/base.blade.php ENDPATH**/ ?>