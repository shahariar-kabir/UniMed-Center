<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'University Medical Centre') | University Medical Centre</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --green:      #1a6b3a;
            --green-dk:   #114927;
            --green-lt:   #2d9156;
            --green-pale: #eaf6ee;
            --gold:       #c8922a;
            --gold-lt:    #fdf6e7;
            --bg:         #f4f8f5;
            --card:       #ffffff;
            --text:       #1c2b22;
            --muted:      #5b7763;
            --border:     #cde0d3;
            --radius:     6px;
            --shadow:     0 2px 8px rgba(0,0,0,.08);
            --shadow-sm:  0 1px 3px rgba(0,0,0,.06);
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            line-height: 1.5;
            font-size: 14px;
        }

        /* ── TOP UTILITY TOOLBAR ── */
        .prototype-bar {
            background: #0b331a;
            color: #d1e7dd;
            padding: 8px 2rem;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            font-size: 11px;
            border-bottom: 1px solid rgba(255,255,255,.1);
            flex-wrap: wrap;
            gap: .6rem;
        }
        .proto-badge {
            background: var(--gold);
            color: #fff;
            padding: 2px 8px;
            border-radius: 3px;
            font-weight: 700;
            letter-spacing: .05em;
            text-transform: uppercase;
        }
        .proto-nav {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }
        .proto-btn {
            background: rgba(255,255,255,.12);
            color: #fff;
            padding: 3px 10px;
            border-radius: 3px;
            text-decoration: none;
            font-size: 11px;
            font-weight: 700;
            transition: all .15s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .proto-btn:hover, .proto-btn.active {
            background: var(--gold);
            color: #fff;
        }

        /* ── SITE HEADER ── */
        .site-header {
            background: var(--green);
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            gap: 1.2rem;
            border-bottom: 3px solid var(--gold);
        }
        .site-header a { text-decoration: none; display: flex; align-items: center; gap: 1rem; }
        .logo-box { line-height: 1; }
        .logo-box span { font-size: 1.6rem; font-weight: 700; color: #fff; }
        .logo-box span span { color: #d1e7dd; }
        .divider { width: 1px; height: 38px; background: rgba(255,255,255,.25); }
        .logo-text strong { display: block; font-size: 1.15rem; color: #fff; }
        .logo-text span { font-size: 11px; color: rgba(255,255,255,.82); text-transform: uppercase; letter-spacing: .05em; }
        .header-meta { margin-left: auto; color: rgba(255,255,255,.8); font-size: 12px; text-align: right; line-height: 1.7; }
        .header-meta strong { color: #fff; display: block; font-size: 13px; }

        /* ── NAV BAR ── */
        nav {
            background: var(--green-dk);
            display: flex;
            align-items: center;
            padding: 0 2rem;
            position: sticky; top: 0; z-index: 100;
            box-shadow: 0 2px 6px rgba(0,0,0,.2);
            flex-wrap: wrap;
        }
        .nav-links { display: flex; align-items: center; flex-wrap: wrap; }
        nav a {
            color: rgba(255,255,255,.85);
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            padding: .8rem 1.1rem;
            display: block;
            border-bottom: 3px solid transparent;
            transition: all .15s;
        }
        nav a:hover { color: #fff; background: rgba(255,255,255,.07); }
        nav a.active { color: #fff; border-bottom-color: var(--gold); background: rgba(255,255,255,.08); }

        /* ── BREADCRUMB ── */
        .breadcrumb {
            background: #fff;
            border-bottom: 1px solid var(--border);
            padding: .5rem 2rem;
            font-size: 12px;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: .5rem;
        }
        .breadcrumb a { color: var(--green); text-decoration: none; font-weight: 700; }
        .breadcrumb a:hover { text-decoration: underline; }

        /* ── MAIN ── */
        main {
            flex: 1;
            padding: 1.8rem 2rem;
            max-width: 1240px;
            margin: 0 auto;
            width: 100%;
        }

        /* ── TYPOGRAPHY & CARDS ── */
        .page-title { font-size: 1.7rem; font-weight: 700; color: var(--green); margin-bottom: .25rem; }
        .page-subtitle { font-size: 13px; color: var(--muted); margin-bottom: 1.4rem; border-bottom: 1px solid var(--border); padding-bottom: .85rem; }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            margin-bottom: 1.4rem;
        }
        .card-header {
            background: var(--green);
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            padding: .65rem 1.1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .card-body { padding: 1.2rem; }

        /* ── BUTTONS & BADGES ── */
        .btn {
            display: inline-block;
            padding: .45rem 1.1rem;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: all .15s;
            text-align: center;
            font-family: inherit;
        }
        .btn-green   { background: var(--green); color: #fff; }
        .btn-green:hover { background: var(--green-dk); }
        .btn-outline { background: transparent; color: var(--green); border: 1.5px solid var(--green); }
        .btn-outline:hover { background: var(--green); color: #fff; }
        .btn-gold    { background: var(--gold); color: #fff; }
        .btn-gold:hover { background: #b07e21; }
        .btn-red     { background: #c0392b; color: #fff; }
        .btn-sm      { padding: .28rem .7rem; font-size: 12px; }

        .badge {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .04em;
        }
        .badge-green  { background: #d4edda; color: #155724; }
        .badge-yellow { background: #fff3cd; color: #856404; }
        .badge-red    { background: #f8d7da; color: #721c24; }
        .badge-blue   { background: #d1ecf1; color: #0c5460; }
        .badge-gold   { background: var(--gold-lt); color: var(--gold); border: 1px solid rgba(200,146,42,.3); }

        /* ── STATS GRID ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 1.1rem;
            margin-bottom: 1.4rem;
        }
        .stat-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.1rem;
            box-shadow: var(--shadow-sm);
            border-top: 3px solid var(--green);
        }
        .stat-card.gold { border-top-color: var(--gold); }
        .stat-card.blue { border-top-color: #2980b9; }
        .stat-card.red  { border-top-color: #c0392b; }
        .stat-val { font-size: 1.9rem; font-weight: 700; color: var(--green-dk); line-height: 1.1; }
        .stat-card.gold .stat-val { color: var(--gold); }
        .stat-card.blue .stat-val { color: #2980b9; }
        .stat-card.red  .stat-val { color: #c0392b; }
        .stat-label { font-size: 11px; text-transform: uppercase; color: var(--muted); font-weight: 700; letter-spacing: .05em; margin-top: 5px; }
        .stat-sub { font-size: 11px; color: var(--muted); margin-top: 2px; }

        /* ── TABLES ── */
        .data-table { width: 100%; border-collapse: collapse; font-size: 13px; background: #fff; }
        .data-table th { background: var(--green-dk); color: #fff; padding: .55rem .85rem; text-align: left; font-size: 11px; text-transform: uppercase; font-weight: 700; letter-spacing: .04em; }
        .data-table td { padding: .65rem .85rem; border-bottom: 1px solid #eef4f0; vertical-align: middle; }
        .data-table tr:nth-child(even) td { background: #fafdfb; }
        .data-table tr:hover td { background: #f0f7f2; }

        /* ── FORMS ── */
        .form-label { display: block; font-size: 12px; font-weight: 700; color: var(--text); margin-bottom: 4px; }
        .form-control {
            width: 100%;
            padding: .5rem .75rem;
            border: 1px solid var(--border);
            border-radius: 4px;
            font-size: 13px;
            font-family: inherit;
        }
        .form-control:focus { outline: none; border-color: var(--green); box-shadow: 0 0 0 2px rgba(26,107,58,.15); }

        /* ── TOAST ALERT ── */
        #proto-toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: #1c2b22;
            color: #fff;
            padding: 12px 20px;
            border-radius: 6px;
            box-shadow: 0 4px 14px rgba(0,0,0,.25);
            font-size: 13px;
            display: none;
            z-index: 9999;
            border-left: 4px solid var(--gold);
        }

        /* ── FOOTER ── */
        footer {
            background: var(--green-dk);
            color: rgba(255,255,255,.7);
            font-size: 12px;
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: auto;
            border-top: 3px solid var(--gold);
            flex-wrap: wrap;
            gap: 1rem;
        }
        .footer-links a { color: rgba(255,255,255,.8); text-decoration: none; margin-left: 1rem; font-size: 12px; }
        .footer-links a:hover { color: #fff; text-decoration: underline; }
    </style>
    @stack('styles')
</head>
<body>

{{-- Interactive Role Switcher Header --}}
<div class="prototype-bar">
    <div class="proto-nav">
        <a href="{{ route('demo.home') }}" class="proto-btn {{ request()->routeIs('demo.home') ? 'active' : '' }}">🌐 Landing Page</a>
        <a href="{{ route('demo.patient.dashboard') }}" class="proto-btn {{ request()->routeIs('demo.patient.*') ? 'active' : '' }}">👤 Patient Portal</a>
        <a href="{{ route('demo.doctor.dashboard') }}" class="proto-btn {{ request()->routeIs('demo.doctor.*') ? 'active' : '' }}">🩺 Doctor Desk</a>
        <a href="{{ route('demo.pharmacy.dashboard') }}" class="proto-btn {{ request()->routeIs('demo.pharmacy.*') ? 'active' : '' }}">💊 Pharmacy Module</a>
        <a href="{{ route('demo.admin.dashboard') }}" class="proto-btn {{ request()->routeIs('demo.admin.*') ? 'active' : '' }}">📊 Admin Analytics</a>
    </div>
</div>

{{-- Site Header --}}
<div class="site-header">
    <a href="{{ route('demo.home') }}">
        <div class="logo-box">
            <span>UniMed<span>Center</span></span>
        </div>
        <div class="divider"></div>
        <div class="logo-text">
            <strong>UNIVERSITY MEDICAL CENTRE</strong>
            <span>University Healthcare Services &amp; Clinic</span>
        </div>
    </a>
    <div class="header-meta">
        <strong>Medical Emergency: 0188888888</strong>
        <span>Open 24/7 &bull; Central Medical Building</span>
    </div>
</div>

{{-- Sub Nav --}}
<nav>
    <div class="nav-links">
        <a href="{{ route('demo.home') }}" class="{{ request()->routeIs('demo.home') ? 'active' : '' }}">Overview</a>
        
        @if(request()->routeIs('demo.patient.*'))
            <a href="{{ route('demo.patient.dashboard') }}" class="{{ request()->routeIs('demo.patient.dashboard') ? 'active' : '' }}">Patient Dashboard</a>
            <a href="{{ route('demo.patient.appointments') }}" class="{{ request()->routeIs('demo.patient.appointments') ? 'active' : '' }}">Book Appointment</a>
            <a href="{{ route('demo.patient.queue') }}" class="{{ request()->routeIs('demo.patient.queue') ? 'active' : '' }}">Live Queue Board</a>
            <a href="{{ route('demo.patient.profile') }}" class="{{ request()->routeIs('demo.patient.profile') ? 'active' : '' }}">Medical Profile</a>
        @elseif(request()->routeIs('demo.doctor.*'))
            <a href="{{ route('demo.doctor.dashboard') }}" class="{{ request()->routeIs('demo.doctor.dashboard') ? 'active' : '' }}">Doctor Desk</a>
            <a href="{{ route('demo.doctor.queue') }}" class="{{ request()->routeIs('demo.doctor.queue') ? 'active' : '' }}">Consultation Queue</a>
            <a href="{{ route('demo.doctor.history') }}" class="{{ request()->routeIs('demo.doctor.history') ? 'active' : '' }}">Patient Medical History</a>
            <a href="{{ route('demo.doctor.prescription.create') }}" class="{{ request()->routeIs('demo.doctor.prescription.create') ? 'active' : '' }}">E-Prescription Builder</a>
            <a href="{{ route('demo.doctor.prescription.preview') }}" class="{{ request()->routeIs('demo.doctor.prescription.preview') ? 'active' : '' }}">Printable Prescription PDF</a>
        @elseif(request()->routeIs('demo.pharmacy.*'))
            <a href="{{ route('demo.pharmacy.dashboard') }}" class="{{ request()->routeIs('demo.pharmacy.dashboard') ? 'active' : '' }}">Pharmacy Dashboard</a>
            <a href="{{ route('demo.pharmacy.inventory') }}" class="{{ request()->routeIs('demo.pharmacy.inventory') ? 'active' : '' }}">Medicine Catalog &amp; Stock</a>
            <a href="{{ route('demo.pharmacy.dispense') }}" class="{{ request()->routeIs('demo.pharmacy.dispense') ? 'active' : '' }}">Dispense Counter</a>
        @elseif(request()->routeIs('demo.admin.*'))
            <a href="{{ route('demo.admin.dashboard') }}" class="{{ request()->routeIs('demo.admin.dashboard') ? 'active' : '' }}">Executive Analytics</a>
            <a href="{{ route('demo.admin.users') }}" class="{{ request()->routeIs('demo.admin.users') ? 'active' : '' }}">User &amp; Role Management</a>
        @else
            <a href="{{ route('demo.patient.register') }}" class="{{ request()->routeIs('demo.patient.register') ? 'active' : '' }}">Patient Registration</a>
            <a href="{{ route('demo.patient.appointments') }}">Book Appointment</a>
            <a href="{{ route('demo.patient.queue') }}">Live Queue Board</a>
        @endif
    </div>
</nav>

{{-- Breadcrumb --}}
<div class="breadcrumb">
    <a href="{{ route('demo.home') }}">Home</a>
    <span>&rsaquo;</span>
    <span>@yield('title', 'Medical Centre')</span>
</div>

<main>
    @yield('content')
</main>

<footer>
    <div>
        &copy; {{ date('Y') }} University Medical Centre Management System &bull; Healthcare Services Division
    </div>
    <div class="footer-links">
        <a href="{{ route('demo.home') }}">Overview</a>
        <a href="{{ route('demo.patient.dashboard') }}">Patient</a>
        <a href="{{ route('demo.doctor.dashboard') }}">Doctor</a>
        <a href="{{ route('demo.pharmacy.dashboard') }}">Pharmacy</a>
        <a href="{{ route('demo.admin.dashboard') }}">Admin</a>
    </div>
</footer>

<div id="proto-toast"></div>

<script>
    function showToast(msg) {
        const toast = document.getElementById('proto-toast');
        toast.innerText = msg;
        toast.style.display = 'block';
        setTimeout(() => { toast.style.display = 'none'; }, 2800);
    }
</script>
@stack('scripts')
</body>
</html>
