<script>
    /* Tabel interaktif: urutkan kolom (klik judul), filter cepat, header menempel, dan kepadatan baris. */
    (function () {
        var DATE = /^(\d{2})\/(\d{2})\/(\d{4})/;
        var NUM = /^(rp\s*)?-?[\d.,]+(\s*(hari|unit|x))?$/i;

        function nilai(td) {
            var v = td.getAttribute('data-sort-value');
            var t = (v !== null ? v : td.textContent).replace(/\s+/g, ' ').trim();
            var d = DATE.exec(t);
            if (d) return { n: new Date(d[3], d[2] - 1, d[1]).getTime() };
            if (t && NUM.test(t)) { var x = parseFloat(t.replace(/[^\d,-]/g, '').replace(',', '.')); if (!isNaN(x)) return { n: x }; }
            return { s: t.toLowerCase() };
        }
        function banding(a, b) {
            if (a.n !== undefined && b.n !== undefined) return a.n - b.n;
            if (a.n !== undefined) return -1;
            if (b.n !== undefined) return 1;
            return (a.s || '').localeCompare(b.s || '', 'id', { numeric: true });
        }

        document.querySelectorAll('main table.tbl').forEach(function (t) {
            var body = t.tBodies[0];
            if (!body || !t.tHead) return;
            var rows = Array.prototype.slice.call(body.rows);
            if (!rows.length || (rows.length === 1 && rows[0].cells.length === 1)) return; // tampilan kosong

            /* --- urutkan --- */
            var ths = t.tHead.rows[0].cells;
            Array.prototype.forEach.call(ths, function (th, ci) {
                var label = th.textContent.trim().toLowerCase();
                if (!label || label === 'aksi') return;
                th.setAttribute('data-sort', ''); th.setAttribute('tabindex', '0'); th.setAttribute('title', 'Klik untuk mengurutkan');
                var ind = document.createElement('i'); ind.className = 'fa-solid fa-sort sort-ind'; th.appendChild(ind);
                function urut() {
                    var naik = th.getAttribute('aria-sort') !== 'ascending';
                    Array.prototype.forEach.call(ths, function (o) { o.removeAttribute('aria-sort'); var i = o.querySelector('.sort-ind'); if (i) i.className = 'fa-solid fa-sort sort-ind'; });
                    th.setAttribute('aria-sort', naik ? 'ascending' : 'descending');
                    ind.className = 'fa-solid ' + (naik ? 'fa-sort-up' : 'fa-sort-down') + ' sort-ind';
                    var data = Array.prototype.slice.call(body.rows).map(function (r) { return { r: r, k: r.cells[ci] ? nilai(r.cells[ci]) : { s: '' } }; });
                    data.sort(function (a, b) { return (naik ? 1 : -1) * banding(a.k, b.k); });
                    data.forEach(function (d) { body.appendChild(d.r); });
                }
                th.addEventListener('click', urut);
                th.addEventListener('keydown', function (e) { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); urut(); } });
            });

            /* --- header menempel untuk tabel panjang --- */
            var wrap = t.closest('.overflow-x-auto') || t.parentElement;
            if (rows.length >= 8) { wrap.classList.remove('overflow-x-auto'); wrap.classList.add('tbl-scroll'); }

            /* --- filter cepat + kepadatan (tabel dengan banyak baris) --- */
            if (rows.length < 6) return;
            var bar = document.createElement('div');
            bar.className = 'flex flex-wrap items-center gap-3 border-b border-slate-100 bg-white px-5 py-2.5';
            bar.innerHTML =
                '<div class="relative"><i class="fa-solid fa-filter absolute left-2.5 top-1/2 -translate-y-1/2 text-[11px] text-slate-400"></i>' +
                '<input type="text" autocomplete="off" placeholder="Filter baris di halaman ini..." class="input !py-1.5 w-60 pl-8 text-xs"></div>' +
                '<span class="text-xs text-slate-500" data-count></span>' +
                '<button type="button" class="btn btn-outline btn-sm ml-auto" data-density title="Ubah kepadatan baris"><i class="fa-solid fa-grip-lines text-[10px]"></i> <span></span></button>';
            wrap.parentNode.insertBefore(bar, wrap);

            var input = bar.querySelector('input'), cnt = bar.querySelector('[data-count]');
            function hitung() {
                var q = input.value.trim().toLowerCase(), tampil = 0;
                Array.prototype.forEach.call(body.rows, function (r) {
                    var cocok = !q || r.textContent.toLowerCase().indexOf(q) !== -1;
                    r.style.display = cocok ? '' : 'none'; if (cocok) tampil++;
                });
                cnt.textContent = q ? tampil + ' dari ' + body.rows.length + ' baris cocok' : body.rows.length + ' baris';
            }
            input.addEventListener('input', hitung); hitung();

            var tombol = bar.querySelector('[data-density]');
            function labelPadat() { tombol.querySelector('span').textContent = document.documentElement.getAttribute('data-density') === 'compact' ? 'Padat' : 'Lega'; }
            tombol.addEventListener('click', function () {
                var d = document.documentElement, padat = d.getAttribute('data-density') === 'compact';
                if (padat) d.removeAttribute('data-density'); else d.setAttribute('data-density', 'compact');
                try { padat ? localStorage.removeItem('sp_density') : localStorage.setItem('sp_density', 'compact'); } catch (e) {}
                document.querySelectorAll('[data-density] span').forEach(function (s) { s.textContent = padat ? 'Lega' : 'Padat'; });
            });
            labelPadat();
        });
    })();
</script>
<?php /**PATH C:\Users\user\Downloads\sipinbar-laravel_FINAL_petugas_v6_3\sipinbar-laravel_neww\resources\views/layouts/partials/table-enhance.blade.php ENDPATH**/ ?>