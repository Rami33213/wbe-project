@extends('layouts.auth')

@section('title', 'إنشاء حساب جديد')

@section('content')
<div class="auth-card">
    <h1 class="auth-title">إنشاء حساب جديد</h1>
    <p class="auth-subtitle">اختر نوع حسابك وأدخل بياناتك للبدء باستخدام المنصة.</p>

    <div id="registerSuccess" class="auth-alert auth-alert-success" style="display:none;"></div>
    <div id="registerErrors" class="auth-alert auth-alert-error" style="display:none;"></div>

    <form id="registerForm" class="auth-form">
        <div class="form-row">
            <label for="name">الاسم الكامل <span class="required">*</span></label>
            <input type="text" id="name" name="name" placeholder="مثال: أحمد محمد" required>
        </div>

        <div class="form-row">
            <label for="email">البريد الإلكتروني <span class="required">*</span></label>
            <input type="email" id="email" name="email" placeholder="example@mail.com" required>
        </div>

        <div class="form-row">
            <label for="phone">رقم الجوال</label>
            <input type="text" id="phone" name="phone" placeholder="مثال: 0551234567">
        </div>

        <div class="form-row">
            <label for="location_city">المدينة</label>
            <input type="text" id="location_city" name="location_city" placeholder="مثال: الرياض / جدة / ...">
        </div>

        <div class="form-row">
            <label for="location_area">الحي / المنطقة</label>
            <input type="text" id="location_area" name="location_area" placeholder="مثال: حي النرجس">
        </div>

        <div class="form-row">
            <label for="role">نوع الحساب <span class="required">*</span></label>
            <select id="role" name="role" required>
                <option value="">اختر نوع الحساب</option>
                <option value="customer">زبون (أبحث عن خدمات)</option>
                <option value="provider">مقدّم خدمة (أقدّم الخدمات)</option>
            </select>
        </div>

        <div class="form-row">
            <label for="password">كلمة المرور <span class="required">*</span></label>
            <input type="password" id="password" name="password" placeholder="•••••••" required>
        </div>

        <div class="form-row">
            <label for="password_confirmation">تأكيد كلمة المرور</label>
            <input type="password" id="password_confirmation" placeholder="أعد إدخال كلمة المرور">
        </div>

        <button type="submit" class="btn-primary" id="registerBtn">
            إنشاء الحساب
        </button>

        <p class="auth-switch">
            لديك حساب بالفعل؟
            <a href="{{ url('/login') }}">تسجيل الدخول</a>
        </p>
    </form>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form    = document.getElementById('registerForm');
    const btn     = document.getElementById('registerBtn');
    const errors  = document.getElementById('registerErrors');
    const success = document.getElementById('registerSuccess');

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        errors.style.display = 'none';
        success.style.display = 'none';
        errors.innerHTML = '';
        success.innerHTML = '';

        // تحقق من كلمة المرور والتأكيد (فرونت فقط)
        const password = document.getElementById('password').value;
        const confirm  = document.getElementById('password_confirmation').value;
        if (confirm && password !== confirm) {
            errors.style.display = 'block';
            errors.innerHTML = 'كلمتا المرور غير متطابقتين.';
            return;
        }

        btn.disabled = true;
        btn.textContent = 'جاري إنشاء الحساب...';

        const payload = {
            name: document.getElementById('name').value,
            email: document.getElementById('email').value,
            phone: document.getElementById('phone').value,
            location_city: document.getElementById('location_city').value,
            location_area: document.getElementById('location_area').value,
            role: document.getElementById('role').value,
            password: password,
        };

        try {
            const response = await fetch('/api/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(payload),
            });

            const data = await response.json();

            if (!response.ok) {
                // أخطاء Validation من Laravel
                let msg = '';

                if (data.errors) {
                    Object.keys(data.errors).forEach(function (field) {
                        msg += '<div>' + data.errors[field].join('<br>') + '</div>';
                    });
                } else if (data.message) {
                    msg = data.message;
                } else {
                    msg = 'حدث خطأ غير متوقّع، حاول مرّة أخرى.';
                }

                errors.style.display = 'block';
                errors.innerHTML = msg;
            } else {
                // ✅ نفترض أن /api/register يرجّع نفس فورمات /api/login: token + user
                if (data.token) {
                    localStorage.setItem('auth_token', data.token);
                }

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
                success.innerHTML = 'تم إنشاء الحساب بنجاح! سيتم نقلك الآن...';

                setTimeout(function () {
                    window.location.href = redirectUrl;
                }, 1200);
            }
        } catch (err) {
            errors.style.display = 'block';
            errors.innerHTML = 'فشل الاتصال بالخادم، تأكدي أن السيرفر يعمل.';
        } finally {
            btn.disabled = false;
            btn.textContent = 'إنشاء الحساب';
        }
    });
});
</script>
@endsection
