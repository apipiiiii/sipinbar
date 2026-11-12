<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="color-scheme" content="light">
<script>
    (function () { try {
        var d = document.documentElement, l = localStorage;
        var a = l.getItem('sp_accent'); if (a) d.setAttribute('data-accent', a);
        if (l.getItem('sp_sb') === '1') d.setAttribute('data-sb', 'collapsed');
        var t = l.getItem('sp_density'); if (t) d.setAttribute('data-density', t);
    } catch (e) {} })();
</script>
<link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect width='32' height='32' rx='8' fill='%23BF4A0C'/%3E%3Cpath d='M8 12l8-4 8 4v9l-8 4-8-4z' fill='none' stroke='white' stroke-width='2' stroke-linejoin='round'/%3E%3Cpath d='M8 12l8 4 8-4M16 16v9' fill='none' stroke='white' stroke-width='2' stroke-linejoin='round'/%3E%3C/svg%3E">
<title>@yield('title', 'SIPINBAR') | SIPINBAR</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<script src="https://cdn.tailwindcss.com"></script>
<script>
    /* Satu sumber tema untuk semua role (Admin, Petugas, Siswa). */
    tailwind.config = {
        darkMode: 'class', // tampilan selalu terang (tidak mengikuti mode gelap perangkat)
        theme: {
            extend: {
                fontFamily: { sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'] },
                colors: {
                    brand: { 50:'rgb(var(--b50) / <alpha-value>)', 100:'rgb(var(--b100) / <alpha-value>)', 200:'rgb(var(--b200) / <alpha-value>)', 300:'rgb(var(--b300) / <alpha-value>)', 400:'rgb(var(--b400) / <alpha-value>)', 500:'rgb(var(--b500) / <alpha-value>)', 600:'rgb(var(--b600) / <alpha-value>)', 700:'rgb(var(--b700) / <alpha-value>)', 800:'rgb(var(--b800) / <alpha-value>)', 900:'rgb(var(--b900) / <alpha-value>)' },
                    slate: { 50:'#FAFAF9',100:'#F5F5F4',200:'#E7E5E4',300:'#D6D3D1',400:'#A8A29E',500:'#78716C',600:'#57534E',700:'#44403C',800:'#292524',900:'#1C1917' },
                },
                borderRadius: { lg: '8px', xl: '10px', '2xl': '12px' },
                boxShadow: {
                    soft: '0 1px 2px rgba(28,25,23,.05)',
                    card: '0 1px 2px rgba(28,25,23,.05)',
                    pop: '0 10px 30px -8px rgba(28,25,23,.18)',
                },
            }
        }
    }
</script>
<style type="text/tailwindcss">
    @layer base {
        html { font-size: 15px; color-scheme: light; -webkit-font-smoothing: antialiased; }
        body { @apply bg-slate-50 font-sans text-slate-800; }
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-thumb { background: #D6D3D1; border-radius: 999px; }
    }
    @layer components {
        .card { @apply bg-white border border-slate-200 rounded-xl shadow-soft; }
        .card-head { @apply flex items-center justify-between gap-3 px-5 py-3.5 border-b border-slate-100; }
        .card-title { @apply text-sm font-semibold text-slate-900; }
        .card-body { @apply p-5; }

        .page-title { @apply text-xl font-semibold tracking-tight text-slate-900; }
        .page-sub { @apply text-sm text-slate-500 mt-0.5; }

        .btn { @apply inline-flex items-center justify-center gap-2 rounded-lg px-3.5 py-2 text-sm font-medium transition focus:outline-none focus-visible:ring-4 focus-visible:ring-brand-500/20 disabled:opacity-50 disabled:cursor-not-allowed; }
        .btn:not(:disabled):active { transform: scale(.98); }
        .btn-primary { @apply bg-brand-600 text-white hover:bg-brand-700 active:bg-brand-800; }
        .btn-outline { @apply bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:border-slate-300; }
        .btn-danger { @apply bg-white border border-rose-200 text-rose-700 hover:bg-rose-50; }
        .btn-sm { @apply px-2.5 py-1.5 text-xs; }
        .btn-icon { @apply h-8 w-8 p-0; }

        .input { @apply w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 outline-none transition focus:border-brand-500 focus:ring-4 focus:ring-brand-500/15; }
        .label { @apply block text-xs font-semibold text-slate-600 mb-1.5; }

        .tbl { @apply w-full text-sm text-left; }
        .tbl thead tr { @apply bg-slate-50 text-[11px] font-semibold uppercase tracking-wider text-slate-500; }
        .tbl th { @apply px-5 py-2.5 whitespace-nowrap; }
        .tbl td { @apply px-5 py-3; }
        .tbl tbody { @apply divide-y divide-slate-100; }
        .tbl tbody tr { @apply transition hover:bg-slate-50/70; }

        .kpi-label { @apply text-xs font-medium text-slate-500; }
        .kpi-value { @apply mt-1 text-2xl font-semibold tracking-tight text-slate-900; }
        .kpi-note { @apply mt-1 text-xs text-slate-500; }

        .link { @apply font-medium text-brand-700 hover:text-brand-800 hover:underline underline-offset-2; }
    }
</style>
<style>
    /* ---- Aksen warna (default: Terakota). Dipilih pengguna di halaman Profil. ---- */
    :root { --b50:255 245 236; --b100:255 232 212; --b200:253 203 163; --b300:249 169 108; --b400:242 132 56; --b500:224 101 26; --b600:191 74 12; --b700:156 59 10; --b800:124 48 13; --b900:102 41 15; }
    :root[data-accent="magenta"] { --b50:253 244 255; --b100:250 232 255; --b200:245 208 254; --b300:240 171 252; --b400:232 121 249; --b500:192 38 211; --b600:162 28 175; --b700:134 25 143; --b800:112 26 117; --b900:74 4 78; }
    :root[data-accent="indigo"]  { --b50:238 242 255; --b100:224 231 255; --b200:199 210 254; --b300:165 180 252; --b400:129 140 248; --b500:99 102 241; --b600:79 70 229; --b700:67 56 202; --b800:55 48 163; --b900:49 46 129; }
    :root[data-accent="grafit"]  { --b50:250 250 249; --b100:245 245 244; --b200:231 229 228; --b300:214 211 209; --b400:168 162 158; --b500:120 113 108; --b600:68 64 60; --b700:41 37 36; --b800:28 25 23; --b900:12 10 9; }

    /* ---- Animasi masuk bertahap ---- */
    @keyframes sp-up { from { opacity: 0; transform: translateY(10px); } }
    main .card:not(.rv), main > section { animation: sp-up .5s cubic-bezier(.2,.7,.2,1) backwards; }
    main .card:nth-child(2) { animation-delay: .06s; } main .card:nth-child(3) { animation-delay: .12s; }
    main .card:nth-child(4) { animation-delay: .18s; } main .card:nth-child(5) { animation-delay: .24s; }
    main .card:nth-child(n+6) { animation-delay: .3s; }

    /* Bar progres terisi dari kiri */
    @keyframes sp-grow { from { transform: scaleX(0); } }
    .overflow-hidden.rounded-full > div[style*="width"] { transform-origin: left center; animation: sp-grow .9s .25s cubic-bezier(.2,.7,.2,1) backwards; }

    /* Skeleton pada area grafik sampai Chart.js selesai menggambar */
    @keyframes sp-shimmer { from { background-position: 100% 0; } to { background-position: -100% 0; } }
    div:has(> canvas:not([data-ready])) { position: relative; }
    div:has(> canvas:not([data-ready]))::before { content: ""; position: absolute; inset: 0; z-index: 1; border-radius: 8px; background: linear-gradient(90deg, #F5F5F4 25%, #E7E5E4 37%, #F5F5F4 63%); background-size: 300% 100%; animation: sp-shimmer 1.4s linear 8; }

    /* ---- Interaksi kecil ---- */
    @keyframes sp-wiggle { 0%,100% { transform: rotate(0); } 15% { transform: rotate(14deg); } 30% { transform: rotate(-12deg); } 45% { transform: rotate(9deg); } 60% { transform: rotate(-6deg); } 75% { transform: rotate(3deg); } }
    .sp-wiggle { animation: sp-wiggle .9s ease-in-out; transform-origin: 50% 0; }
    @keyframes sp-toast-in { from { opacity: 0; transform: translateX(16px); } }
    @keyframes sp-pop { from { transform: scale(.3); } }
    [data-toast] { animation: sp-toast-in .35s cubic-bezier(.2,.7,.2,1); }
    [data-toast] > span:first-child { animation: sp-pop .5s .15s cubic-bezier(.3,1.6,.5,1) backwards; }
    .btn-primary:not(:disabled):hover { box-shadow: 0 4px 12px -4px rgb(var(--b600) / .55); transform: translateY(-1px); }
    .btn-primary:not(:disabled):active { transform: scale(.98); }

    /* ---- Sidebar admin yang bisa dilipat ---- */
    #sp-sidebar { transition: width .2s ease, transform .2s ease; }
    @media (min-width: 1024px) {
        #sp-main-wrap { transition: padding-left .2s ease; }
        html[data-sb="collapsed"] #sp-sidebar { width: 72px; }
        html[data-sb="collapsed"] #sp-main-wrap { padding-left: 72px; }
        html[data-sb="collapsed"] #sp-sidebar .sb-label,
        html[data-sb="collapsed"] #sp-sidebar .sb-group-title { display: none; }
        html[data-sb="collapsed"] #sp-sidebar .sb-item { justify-content: center; padding-left: 0; padding-right: 0; position: relative; }
        html[data-sb="collapsed"] #sp-sidebar .sb-brand { justify-content: center; padding-left: 0; padding-right: 0; }
        html[data-sb="collapsed"] #sp-sidebar .sb-badge { display: block; position: absolute; top: 6px; right: 16px; min-width: 8px; width: 8px; height: 8px; padding: 0; font-size: 0; }
        html[data-sb="collapsed"] #sp-sb-toggle i { transform: rotate(180deg); }
    }

    /* ---- Tabel interaktif ---- */
    html[data-density="compact"] .tbl td, html[data-density="compact"] .tbl th { padding-top: .35rem; padding-bottom: .35rem; }
    .tbl-scroll { max-height: 72vh; overflow: auto; }
    .tbl-scroll thead th { position: sticky; top: 0; z-index: 2; background: #FAFAF9; box-shadow: inset 0 -1px 0 #E7E5E4; }
    .tbl th[data-sort] { cursor: pointer; user-select: none; }
    .tbl th[data-sort]:hover { color: #1C1917; }
    .tbl th .sort-ind { display: inline-block; margin-left: .35rem; font-size: 9px; opacity: .35; }
    .tbl th[aria-sort] .sort-ind { opacity: 1; color: rgb(var(--b700)); }

    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after { animation: none !important; transition: none !important; }
    }
    @media print {
        header, aside, nav, #sp-toasts, .no-print { display: none !important; }
        body { background: #fff !important; }
        [class*="lg:pl-"] { padding-left: 0 !important; }
        main { max-width: none !important; padding: 0 !important; }
        main .card, main > section { animation: none !important; }
        .card { box-shadow: none !important; }
    }
</style>
@stack('styles')
<style>
    /* Latar dekoratif halaman sebelum login */
    .bg-hero { position: relative; isolation: isolate; background:
        radial-gradient(900px 500px at 85% -10%, rgb(var(--b200) / .55), transparent 60%),
        radial-gradient(700px 450px at -10% 110%, rgb(var(--b100) / .9), transparent 60%),
        #FAFAF9; }
    .bg-hero::before { content: ""; position: absolute; inset: 0; z-index: -1; opacity: .55;
        background-image: radial-gradient(rgb(var(--b300) / .55) 1.2px, transparent 1.2px); background-size: 22px 22px;
        -webkit-mask-image: linear-gradient(180deg, #000 0%, transparent 85%); mask-image: linear-gradient(180deg, #000 0%, transparent 85%); }
    .bg-panel { position: relative; isolation: isolate; overflow: hidden; background:
        radial-gradient(600px 400px at 100% 0%, rgb(var(--b500) / .55), transparent 65%),
        radial-gradient(500px 400px at 0% 100%, rgb(var(--b900) / .9), transparent 70%),
        rgb(var(--b800)); }
    .bg-panel::before { content: ""; position: absolute; inset: 0; z-index: -1;
        background-image: linear-gradient(rgb(255 255 255 / .06) 1px, transparent 1px), linear-gradient(90deg, rgb(255 255 255 / .06) 1px, transparent 1px);
        background-size: 38px 38px; -webkit-mask-image: radial-gradient(ellipse at 30% 40%, #000 20%, transparent 75%); mask-image: radial-gradient(ellipse at 30% 40%, #000 20%, transparent 75%); }
    .deco-ico { position: absolute; z-index: -1; display: flex; align-items: center; justify-content: center; border-radius: 16px; color: rgb(255 255 255 / .85);
        background: rgb(255 255 255 / .08); border: 1px solid rgb(255 255 255 / .15); backdrop-filter: blur(2px); animation: floaty 7s ease-in-out infinite; }
    .deco-ico-lt { color: rgb(var(--b600)); background: rgb(255 255 255 / .75); border-color: rgb(var(--b200)); }
    @keyframes floaty { 0%,100% { transform: translateY(0) rotate(var(--r,0deg)); } 50% { transform: translateY(-12px) rotate(var(--r,0deg)); } }
    @media (prefers-reduced-motion: reduce) { .deco-ico { animation: none; } }
</style>
