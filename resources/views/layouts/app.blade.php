<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'InventoryPro')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
          rel="stylesheet">

    <style>
        :root {
            --green-dark: #14532d;
            --green: #15803d;
            --green-light: #dcfce7;
            --page-bg: #f5f9f5;
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --border: #e5ece6;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: var(--page-bg);
            color: var(--text-main);
            font-family: Inter, "Segoe UI", Arial, sans-serif;
        }

        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 1000;
            width: 250px;
            padding: 28px 18px;
            color: white;
            background: linear-gradient(180deg, #14532d, #166534);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 0 8px 38px;
            font-size: 21px;
            font-weight: 800;
            letter-spacing: -.5px;
        }

        .brand-icon {
            display: grid;
            place-items: center;
            width: 42px;
            height: 42px;
            border-radius: 13px;
            background: rgba(255,255,255,.15);
            font-size: 23px;
        }

        .menu-label {
            padding: 0 12px;
            margin-bottom: 12px;
            color: #bbf7d0;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 14px;
            margin-bottom: 8px;
            color: #dcfce7;
            text-decoration: none;
            border-radius: 11px;
            transition: .2s ease;
        }

        .sidebar a:hover,
        .sidebar a.active {
            color: white;
            background: rgba(255,255,255,.16);
        }

        .sidebar a i { font-size: 18px; }

        .sidebar-footer {
            position: absolute;
            right: 18px;
            bottom: 22px;
            left: 18px;
            padding: 15px 12px;
            border-top: 1px solid rgba(255,255,255,.18);
            color: #dcfce7;
            font-size: 12px;
        }

        .main-content {
            min-height: 100vh;
            margin-left: 250px;
            padding: 30px;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 28px;
        }

        .page-title {
            margin: 0 0 6px;
            font-size: clamp(23px, 3vw, 29px);
            font-weight: 800;
            letter-spacing: -.7px;
        }

        .page-subtitle {
            margin: 0;
            color: var(--text-muted);
            font-size: 14px;
        }

        .admin-chip {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
        }

        .admin-avatar {
            display: grid;
            place-items: center;
            width: 35px;
            height: 35px;
            border-radius: 10px;
            color: var(--green);
            background: var(--green-light);
            font-size: 18px;
        }

        .stat-card, .panel {
            height: 100%;
            padding: 23px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 17px;
            box-shadow: 0 5px 20px rgba(20, 83, 45, .035);
        }

        .stat-label {
            margin-bottom: 10px;
            color: var(--text-muted);
            font-size: 13px;
            font-weight: 600;
        }

        .stat-value {
            margin: 0;
            font-size: 29px;
            font-weight: 800;
            letter-spacing: -.7px;
        }

        .stat-icon {
            display: grid;
            place-items: center;
            width: 49px;
            height: 49px;
            border-radius: 14px;
            color: var(--green);
            background: var(--green-light);
            font-size: 23px;
        }

        .stat-note {
            margin-top: 12px;
            color: var(--text-muted);
            font-size: 12px;
        }

        .panel-heading {
            margin-bottom: 5px;
            font-size: 17px;
            font-weight: 800;
        }

        .panel-description {
            color: var(--text-muted);
            font-size: 13px;
        }

        .btn-green {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 15px;
            color: white;
            background: var(--green);
            border: 1px solid var(--green);
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            transition: .2s;
        }

        .btn-green:hover {
            color: white;
            background: var(--green-dark);
            border-color: var(--green-dark);
        }

        .form-control, .form-select, .input-group-text {
            min-height: 43px;
            border-color: #dce6dd;
            border-radius: 9px;
        }

        .input-group .input-group-text {
            border-radius: 9px 0 0 9px;
        }

        .input-group .form-control {
            border-radius: 0 9px 9px 0;
        }

        .form-control:focus, .form-select:focus {
            border-color: #86c99c;
            box-shadow: 0 0 0 .2rem rgba(21,128,61,.1);
        }

        .table-responsive { overflow-x: auto; }

        .table {
            min-width: 760px;
            margin: 0;
            vertical-align: middle;
        }

        .table thead th {
            padding: 15px 13px;
            color: #647568;
            background: #f6faf6;
            border-bottom: 1px solid var(--border);
            font-size: 11px;
            letter-spacing: .7px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 15px 13px;
            border-bottom: 1px solid #edf2ed;
            font-size: 13px;
        }

        .table tbody tr:hover { background: #fbfefb; }
        .table tbody tr:last-child td { border-bottom: 0; }

        .product-name { font-weight: 700; }

        .sku-badge {
            padding: 6px 9px;
            color: #475569;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 7px;
            font-size: 12px;
        }

        .stock-badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .stock-ok { color: #166534; background: #dcfce7; }
        .stock-low { color: #b45309; background: #fef3c7; }
        .stock-empty { color: #b91c1c; background: #fee2e2; }

        .action-btn {
            display: inline-grid;
            place-items: center;
            width: 33px;
            height: 33px;
            color: #4b6350;
            background: white;
            border: 1px solid #e1e9e1;
            border-radius: 9px;
            text-decoration: none;
        }

        .action-btn:hover {
            color: var(--green);
            background: var(--green-light);
        }

        .action-delete:hover {
            color: #dc2626;
            background: #fee2e2;
        }

        .empty-state {
            padding: 45px 15px !important;
            color: var(--text-muted);
            text-align: center;
        }

        .pagination { gap: 4px; }
        .pagination .page-link {
            color: var(--green);
            border-radius: 8px !important;
            border-color: var(--border);
        }
        .pagination .active .page-link {
            color: white;
            background: var(--green);
            border-color: var(--green);
        }

        .alert { border-radius: 12px; }

        @media (max-width: 900px) {
            .sidebar { width: 215px; }
            .main-content { margin-left: 215px; padding: 22px; }
        }

        @media (max-width: 650px) {
            .sidebar {
                position: relative;
                width: 100%;
                padding: 16px;
            }

            .brand { margin: 0 0 15px; }
            .menu-label { margin-top: 15px; }
            .sidebar a { display: inline-flex; padding: 10px 12px; }
            .sidebar-footer { display: none; }
            .main-content { margin-left: 0; padding: 17px; }
            .topbar { align-items: flex-start; }
            .admin-chip { padding: 8px; }
            .admin-chip .admin-text { display: none; }
            .stat-card, .panel { padding: 18px; }
        }
    </style>

    @stack('styles')
</head>
<body>

    <aside class="sidebar">
        <div class="brand">
            <span class="brand-icon"><i class="bi bi-box-seam"></i></span>
            <span>Inventory<span style="color:#86efac">SI</span></span>
        </div>

        <div class="menu-label">Menu Utama</div>

        <a href="{{ route('products.index') }}"
           class="{{ request()->routeIs('products.index') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2"></i>
            Dashboard
        </a>

        @auth
    @if(auth()->user()->isAdmin())
        <a href="{{ route('products.create') }}"
           class="{{ request()->routeIs('products.create') ? 'active' : '' }}">
            <i class="bi bi-plus-circle"></i>
            Tambah Produk
        </a>
    @endif
@endauth

        <div class="sidebar-footer">
            <i class="bi bi-shield-check me-2"></i>
            Sistem Inventaris
        </div>
    </aside>

    <main class="main-content">
        <header class="topbar">
            <div>
                <h1 class="page-title">@yield('heading', 'Dashboard')</h1>
                
            </div>

            
@auth
<div class="d-flex align-items-center gap-2 flex-wrap">

    <div class="admin-chip">
        <span class="admin-avatar">
            <i class="bi bi-person-circle"></i>
        </span>

        <div class="admin-text">
            <div class="fw-bold">
                {{ auth()->user()->name }}
            </div>
            <small class="text-secondary">
                {{ ucfirst(auth()->user()->role) }}
            </small>
        </div>
    </div>

    <form action="{{ route('logout') }}" method="POST" class="m-0">
        @csrf

        <button type="submit"
                class="btn btn-outline-danger d-flex align-items-center gap-2">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
        </button>
    </form>

</div>
@endauth

        </header>

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>