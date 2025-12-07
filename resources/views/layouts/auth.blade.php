<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'منصة الخدمات المنزلية')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSRF لطلبات AJAX إذا احتجتي --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- ملف الـ CSS --}}
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body class="auth-body">

    <header class="auth-header">
        <div class="auth-logo">
            🏠 منصة الخدمات المنزلية
        </div>
        <nav class="auth-nav">
            <a href="{{ url('/login') }}">تسجيل الدخول</a>
            <a href="{{ url('/register') }}">حساب جديد</a>
        </nav>
    </header>

    <main class="auth-main">
        @yield('content')
    </main>

    <footer class="auth-footer">
        <small>مشروع هندسة الويب 2025-2026</small>
    </footer>

    @yield('scripts')
</body>
</html>
