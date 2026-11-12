@push('vendor')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    /* Pengaturan grafik bersama (tema terang SIPINBAR). */
    (function () {
        if (!window.Chart) return;
        Chart.defaults.font.family = "Inter, ui-sans-serif, system-ui, sans-serif";
        Chart.defaults.font.size = 12;
        Chart.defaults.color = '#78716C';
        Chart.defaults.plugins.legend.labels.usePointStyle = true;
        Chart.defaults.plugins.legend.labels.boxWidth = 8;
        Chart.defaults.plugins.tooltip.backgroundColor = '#1C1917';
        Chart.defaults.plugins.tooltip.padding = 10;
        Chart.defaults.plugins.tooltip.cornerRadius = 8;
        Chart.defaults.maintainAspectRatio = false;
        // Tandai kanvas yang sudah digambar (menghilangkan skeleton)
        Chart.register({ id: 'spReady', afterInit: function (c) { c.canvas.setAttribute('data-ready', '1'); } });
    })();

    /* Warna aksen mengikuti pilihan pengguna (variabel CSS --b50 … --b900). */
    function spCss(n, a) {
        var v = getComputedStyle(document.documentElement).getPropertyValue('--b' + n).trim().split(/\s+/).join(',');
        return a == null ? 'rgb(' + v + ')' : 'rgba(' + v + ',' + a + ')';
    }
    function spResolve(c) { var m = /var\(--b(\d+)\)/.exec(c); return m ? spCss(m[1]) : c; }

    window.SP = {
        brand: spCss(600), brandSoft: spCss(200), emerald: '#059669', amber: '#CA8A04', rose: '#E11D48', slate: '#A8A29E',
        grid: { color: '#F5F5F4', drawBorder: false },
        intOnly: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#F5F5F4' }, border: { display: false } },
        noGrid: { grid: { display: false }, border: { display: false } },
        doughnut: function (id, d) {
            return new Chart(document.getElementById(id), {
                type: 'doughnut',
                data: { labels: d.labels, datasets: [{ data: d.data, backgroundColor: d.colors.map(spResolve), borderWidth: 2, borderColor: '#fff' }] },
                options: { cutout: '68%', plugins: { legend: { display: false } } }
            });
        }
    };
</script>
@endpush
