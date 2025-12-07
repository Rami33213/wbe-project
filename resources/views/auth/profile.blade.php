@extends('layouts.auth')

@section('title', 'الملف الشخصي')

@section('content')
<div class="auth-card">
    <h1 class="auth-title">الملف الشخصي</h1>
    <p class="auth-subtitle">يمكنك تعديل بيانات حسابك أو حذف الحساب نهائيًا.</p>

    <div id="profileSuccess" class="auth-alert auth-alert-success" style="display:none;"></div>
    <div id="profileErrors" class="auth-alert auth-alert-error" style="display:none;"></div>

    <form id="profileForm" class="auth-form">
        <div class="form-row">
            <label for="name">الاسم الكامل</label>
            <input type="text" id="name" name="name">
        </div>

        <div class="form-row">
            <label for="email">البريد الإلكتروني (لا يمكن تعديله من هنا)</label>
            <input type="email" id="email" name="email" disabled>
        </div>

        <div class="form-row">
            <label for="phone">رقم الجوال</label>
            <input type="text" id="phone" name="phone">
        </div>

        <div class="form-row">
            <label for="location_city">المدينة</label>
            <input type="text" id="location_city" name="location_city">
        </div>

        <div class="form-row">
            <label for="location_area">الحي / المنطقة</label>
            <input type="text" id="location_area" name="location_area">
        </div>

        <div class="form-row">
            <label for="role">نوع الحساب</label>
            <input type="text" id="role" name="role" disabled>
        </div>

        <div class="form-row">
            <label for="password">تحديث كلمة المرور (اختياري)</label>
            <input type="password" id="password" name="password" placeholder="اتركها فارغة إن لم ترد التغيير">
        </div>

        <button type="submit" class="btn-primary" id="profileBtn">
            حفظ التعديلات
        </button>
    </form>

    <div class="profile-actions">
        <button id="logoutBtn" class="btn-secondary">تسجيل الخروج</button>
        <button id="deleteBtn" class="btn-danger">حذف الحساب نهائيًا</button>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const token = localStorage.getItem('auth_token');
    const errors = document.getElementById('profileErrors');
    const success= document.getElementById('profileSuccess');

    if (!token) {
        window.location.href = '/login';
        return;
    }

    // تحميل بيانات المستخدم من /api/me
    async function loadProfile() {
        errors.style.display = 'none';
        success.style.display = 'none';
        errors.innerHTML = '';
        success.innerHTML = '';

        try {
            const response = await fetch('/api/me', {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token,
                }
            });

            if (!response.ok) {
                errors.style.display = 'block';
                errors.innerHTML = 'فشل تحميل بيانات المستخدم، سيتم نقلك لتسجيل الدخول.';
                setTimeout(() => window.location.href = '/login', 1000);
                return;
            }

            const user = await response.json();

            document.getElementById('name').value = user.name ?? '';
            document.getElementById('email').value = user.email ?? '';
            document.getElementById('phone').value = user.phone ?? '';
            document.getElementById('location_city').value = user.location_city ?? '';
            document.getElementById('location_area').value = user.location_area ?? '';
            document.getElementById('role').value = user.role ?? '';
        } catch (err) {
            errors.style.display = 'block';
            errors.innerHTML = 'خطأ في الاتصال بالخادم.';
        }
    }

    loadProfile();

    // حفظ التعديلات
    const form = document.getElementById('profileForm');
    const btn  = document.getElementById('profileBtn');

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        errors.style.display = 'none';
        success.style.display = 'none';
        errors.innerHTML = '';
        success.innerHTML = '';

        btn.disabled = true;
        btn.textContent = 'جاري الحفظ...';

        const payload = {
            name: document.getElementById('name').value || null,
            phone: document.getElementById('phone').value || null,
            location_city: document.getElementById('location_city').value || null,
            location_area: document.getElementById('location_area').value || null,
            password: document.getElementById('password').value || null,
        };

        try {
            const response = await fetch('/api/me', {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token,
                },
                body: JSON.stringify(payload),
            });

            const data = await response.json();

            if (!response.ok) {
                let msg = '';
                if (data.errors) {
                    Object.keys(data.errors).forEach(function (field) {
                        msg += '<div>' + data.errors[field].join('<br>') + '</div>';
                    });
                } else if (data.message) {
                    msg = data.message;
                } else {
                    msg = 'فشل حفظ التعديلات.';
                }

                errors.style.display = 'block';
                errors.innerHTML = msg;
            } else {
                success.style.display = 'block';
                success.innerHTML = 'تم تحديث بياناتك بنجاح.';
                document.getElementById('password').value = '';
            }
        } catch (err) {
            errors.style.display = 'block';
            errors.innerHTML = 'خطأ في الاتصال بالخادم.';
        } finally {
            btn.disabled = false;
            btn.textContent = 'حفظ التعديلات';
        }
    });

    // تسجيل الخروج
    const logoutBtn = document.getElementById('logoutBtn');
    logoutBtn.addEventListener('click', async function () {
        try {
            await fetch('/api/logout', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token,
                },
            });
        } catch (e) {}

        localStorage.removeItem('auth_token');
        window.location.href = '/login';
    });

    // حذف الحساب
    const deleteBtn = document.getElementById('deleteBtn');
    deleteBtn.addEventListener('click', async function () {
        if (!confirm('هل أنت متأكد من حذف الحساب نهائيًا؟ لا يمكن التراجع عن هذه العملية.')) {
            return;
        }

        try {
            const response = await fetch('/api/me', {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token,
                },
            });

            if (!response.ok) {
                errors.style.display = 'block';
                errors.innerHTML = 'فشل حذف الحساب، حاول مرة أخرى.';
                return;
            }

            localStorage.removeItem('auth_token');
            alert('تم حذف الحساب بنجاح.');
            window.location.href = '/register';
        } catch (err) {
            errors.style.display = 'block';
            errors.innerHTML = 'خطأ في الاتصال بالخادم.';
        }
    });
});
</script>
@endsection
