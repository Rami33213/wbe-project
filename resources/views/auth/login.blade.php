@extends('layouts.auth')

@section('title', 'تسجيل الدخول')

@section('content')
<div class="auth-card">
    <h1 class="auth-title">تسجيل الدخول</h1>
    <p class="auth-subtitle">سجّل دخولك لمتابعة الحجوزات والخدمات.</p>

    <div id="loginSuccess" class="auth-alert auth-alert-success" style="display:none;"></div>
    <div id="loginErrors" class="auth-alert auth-alert-error" style="display:none;"></div>

    <form id="loginForm" class="auth-form">
        <div class="form-row">
            <label for="email">البريد الإلكتروني <span class="required">*</span></label>
            <input type="email" id="email" name="email" placeholder="example@mail.com" required>
        </div>

        <div class="form-row">
            <label for="password">كلمة المرور <span class="required">*</span></label>
            <input type="password" id="password" name="password" placeholder="•••••••" required>
        </div>

        <button type="submit" class="btn-primary" id="loginBtn">
            دخول
        </button>

        <p class="auth-switch">
            ليس لديك حساب؟
            <a href="{{ url('/register') }}">إنشاء حساب جديد</a>
        </p>
    </form>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form    = document.getElementById('loginForm');
    const btn     = document.getElementById('loginBtn');
    const errors  = document.getElementById('loginErrors');
    const success = document.getElementById('loginSuccess');

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        // تصفير الرسائل
        errors.style.display = 'none';
        success.style.display = 'none';
        errors.innerHTML = '';
        success.innerHTML = '';

        btn.disabled = true;
        btn.textContent = 'جاري تسجيل الدخول...';

        const payload = {
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
        };

        try {
            const response = await fetch('/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(payload),
            });

            const data = await response.json();

            if (!response.ok) {
                // أخطاء
                let msg = '';

                if (data.errors) {
                    Object.keys(data.errors).forEach(function (field) {
                        msg += '<div>' + data.errors[field].join('<br>') + '</div>';
                    });
                } else if (data.message) {
                    msg = data.message;
                } else {
                    msg = 'بيانات الدخول غير صحيحة أو حدث خطأ.';
                }

                errors.style.display = 'block';
                errors.innerHTML = msg;
            } else {
                // ✅ نفترض الـ API يرجّع: { token: "...", user: { ... , role: "customer|provider|admin" } }
                if (data.token) {
                    localStorage.setItem('auth_token', data.token);
                }

                // تحديد صفحة التحويل حسب الدور
                let redirectUrl = '/profile';
                if (data.user && data.user.role) {
                    if (data.user.role === 'customer') {
                        redirectUrl = '/customer';
                    } else if (data.user.role === 'provider') {
                        redirectUrl = '/provider';
                    } else if (data.user.role === 'admin') {
                        redirectUrl = '/admin';
                    }
                }

                success.style.display = 'block';
                success.innerHTML = 'تم تسجيل الدخول بنجاح! سيتم نقلك الآن...';

                setTimeout(function () {
                    window.location.href = redirectUrl;
                }, 1000);
            }
        } catch (err) {
            errors.style.display = 'block';
            errors.innerHTML = 'فشل الاتصال بالخادم، تأكدي من تشغيل Laravel.';
        } finally {
            btn.disabled = false;
            btn.textContent = 'دخول';
        }
    });
});
</script>
@endsection
