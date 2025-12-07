<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'منصة الخدمات المنزلية')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- نفس ملف CSS تبع auth + customer عشان نحافظ على شكل موحّد --}}
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer.css') }}">
</head>
<body class="app-body">

<header class="app-header">
    <div class="app-logo">
        🏠 منصة الخدمات المنزلية
    </div>
    <nav class="app-nav">
        <a href="{{ url('/') }}" class="nav-link">الرئيسية</a>
        <a href="{{ url('/login') }}" class="nav-link">تسجيل الدخول</a>
        <a href="{{ url('/register') }}" class="nav-link">إنشاء حساب</a>
    </nav>
</header>

<main class="app-main">
    @yield('content')
</main>

<footer class="app-footer">
    <small>مشروع هندسة الويب 2025-2026</small>
</footer>

@yield('scripts')
</body>
</html>
