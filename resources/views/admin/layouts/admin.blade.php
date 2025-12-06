<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - StyleFashion</title>

    <!-- Bootstrap 5 + Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <style>
        :root {
            --primary: #e74c3c;
            --sidebar-bg: #2c3e50;
            --sidebar-active: #e74c3c;
            --body-bg: #f8f9fa;
        }
        [data-theme="dark"] {
            --sidebar-bg: #1a1a1a;
            --body-bg: #121212;
            color: #e0e0e0;
        }
        body { background: var(--body-bg); transition: all 0.3s; }
        .sidebar {
            position: fixed;
            top: 0; left: 0; bottom: 0;
            width: 250px;
            background: var(--sidebar-bg);
            color: white;
            z-index: 1000;
            overflow-y: auto;
        }
        .sidebar a { color: #bdc3c7; padding: 15px 20px; display: block; text-decoration: none; }
        .sidebar a:hover, .sidebar a.active { background: var(--sidebar-active); color: white; }
        .sidebar i { width: 25px; }
        .main-content { margin-left: 250px; padding: 20px; }
        .header { background: white; padding: 1rem 1.5rem; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,0.1); margin-bottom: 25px; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,0.08); }
        @media (max-width: 992px) {
            .sidebar { width: 80px; }
            .sidebar span { display: none; }
            .main-content { margin-left: 80px; }
        }
    </style>
</head>
<body data-theme="light">

    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="p-4 text-center border-bottom">
            <h5 class="mb-0 text-white">StyleFashion</h5>
        </div>
        <div class="py-3">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.products.index') }}" class="{{ request()->is('admin/products*') ? 'active' : '' }}">
                <i class="fas fa-box"></i> <span>Sản Phẩm</span>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="{{ request()->is('admin/orders*') ? 'active' : '' }}">
                <i class="fas fa-shopping-bag"></i> <span>Đơn Hàng</span>
            </a>
            <a href="{{ route('admin.discounts.index') }}" class="{{ request()->is('admin/discounts*') ? 'active' : '' }}">
                <i class="fas fa-tag"></i> <span>Giảm giá</span>
            </a>
            <a href="" class="{{ request()->is('admin/payments*') ? 'active' : '' }}">
                <i class="fas fa-credit-card"></i> <span>Thanh toán</span>
            </a>
            <a href="" class="{{ request()->is('admin/reviews*') ? 'active' : '' }}">
                <i class="fas fa-star"></i> <span>Đánh giá</span>
            </a>
            <a href="" class="{{ request()->is('admin/users*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> <span>Người Dùng</span>
            </a>
            <hr class="my-4 border-secondary">
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> <span>Đăng Xuất</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <header class="header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0">@yield('title', 'Dashboard')</h4>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span>Xin chào, <strong>{{ Auth::user()->name }}</strong></span>
                <button class="btn btn-outline-secondary btn-sm" onclick="document.body.dataset.theme = document.body.dataset.theme==='dark'?'light':'dark'">
                    <i class="fas fa-moon"></i>
                </button>
            </div>
        </header>

        <div class="content bg-transparent">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>