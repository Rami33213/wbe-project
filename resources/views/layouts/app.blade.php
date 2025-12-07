<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'منصة الخدمات المنزلية')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- نستخدم نفس CSS تبع auth + ملف dashboard (customer.css) --}}
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer.css') }}">
</head>
<body class="app-body">

<header class="app-header">
    <div class="app-logo">
        🏠 منصة الخدمات المنزلية
    </div>
    <nav class="app-nav">
        <button id="appLogoutBtn" class="nav-btn-logout">تسجيل الخروج</button>
    </nav>
</header>

<main class="app-main">
    @yield('content')
</main>

<footer class="app-footer">
    <small>مشروع هندسة الويب 2025-2026</small>
</footer>

@yield('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {
    const logoutBtn = document.getElementById('appLogoutBtn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', async function () {
            const token = localStorage.getItem('auth_token');
            if (token) {
                try {
                    await fetch('/api/logout', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer ' + token,
                        },
                    });
                } catch (e) {}
            }
            localStorage.removeItem('auth_token');
            window.location.href = '/login';
        });
    }
});
</script>
</body>
</html>
