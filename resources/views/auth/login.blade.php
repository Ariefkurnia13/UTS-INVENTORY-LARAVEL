<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk — InventoryPro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { min-height: 100vh; background: linear-gradient(135deg,#dcfce7,#f7fdf8); display:grid; place-items:center; font-family: 'Segoe UI',Arial,sans-serif; }
        .login-card { width: min(430px, calc(100vw - 32px)); background:#fff; border:1px solid #ddede1; border-radius:20px; padding:36px; box-shadow:0 18px 55px rgba(20,83,45,.09); }
        .brand { color:#166534; font-size:26px; font-weight:800; }
        .btn-login { background:#15803d; color:#fff; padding:12px; border:0; border-radius:10px; }
        .btn-login:hover { background:#166534; color:#fff; }
        .form-control { padding:11px; border-radius:10px; }
    </style>
</head>
<body>
    <main class="login-card">
        <div class="brand mb-2">InventoryPro</div>
        <p class="text-secondary mb-4">Masuk untuk mengelola inventaris dan transaksi.</p>
        @if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif
        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif
        <form method="POST" action="{{ route('login.store') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" autocomplete="username" required autofocus>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label fw-semibold">Password</label>
                <input type="password" id="password" name="password" class="form-control" autocomplete="current-password" required>
            </div>
            <button type="submit" class="btn btn-login w-100 fw-semibold">Masuk</button>
        </form>
    </main>
</body>
</html>
