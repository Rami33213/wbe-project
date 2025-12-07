@extends('layouts.app')

@section('title', 'لوحة تحكم المشرف')

@section('content')
<div class="dashboard">
    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-title">لوحة تحكم المشرف</h1>
            <p class="dashboard-subtitle">
                إدارة المستخدمين، مزوّدي الخدمات، التصنيفات، الخدمات، الحجوزات، والتقييمات.
            </p>
        </div>
        <div class="dashboard-badge" id="adminNameBadge">مشرف</div>
    </div>

    <div id="adminAlert" class="auth-alert auth-alert-error" style="display:none;"></div>

    {{-- Tabs --}}
    <div class="tabs">
        <button class="tab-button active" data-target="usersSection">المستخدمون</button>
        <button class="tab-button" data-target="providersSection">مزوّدو الخدمات</button>
        <button class="tab-button" data-target="categoriesSection">التصنيفات</button>
        <button class="tab-button" data-target="servicesSection">الخدمات</button>
        <button class="tab-button" data-target="bookingsSection">تقارير الحجوزات</button>
        <button class="tab-button" data-target="reviewsSection">التقييمات</button>
    </div>

    {{-- 1) إدارة المستخدمين --}}
    <section id="usersSection" class="tab-section active">
        <div class="section-header">
            <h2>المستخدمون</h2>
            <p>عرض جميع المستخدمين وتفعيل/إيقاف الحسابات.</p>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>البريد</th>
                    <th>الدور</th>
                    <th>الحالة</th>
                    <th>إجراء</th>
                </tr>
            </thead>
            <tbody id="adminUsersTableBody">
                <tr><td colspan="6">جاري تحميل البيانات...</td></tr>
            </tbody>
        </table>
    </section>

    {{-- 2) إدارة مزوّدي الخدمات --}}
    <section id="providersSection" class="tab-section">
        <div class="section-header">
            <h2>مزوّدو الخدمات</h2>
            <p>عرض مزوّدي الخدمات، تفعيل/إيقاف وحذف.</p>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>البريد</th>
                    <th>المدينة</th>
                    <th>الحالة</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody id="adminProvidersTableBody">
                <tr><td colspan="6">جاري تحميل البيانات...</td></tr>
            </tbody>
        </table>
    </section>

    {{-- 3) إدارة التصنيفات --}}
    <section id="categoriesSection" class="tab-section">
        <div class="section-header">
            <h2>التصنيفات الأساسية للخدمات</h2>
            <p>إضافة/تعديل/حذف التصنيفات (تنظيف، سباكة، كهرباء...)</p>
        </div>

        <form id="adminAddCategoryForm" class="booking-form-container">
            <div class="form-row">
                <label>اسم التصنيف <span class="required">*</span></label>
                <input type="text" id="adminCategoryName" required placeholder="مثال: تنظيف، سباكة...">
            </div>
            <button type="submit" class="btn-primary-small">إضافة تصنيف</button>
        </form>

        <h3 style="margin-top:16px;">قائمة التصنيفات</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>تعديل الاسم</th>
                    <th>حذف</th>
                </tr>
            </thead>
            <tbody id="adminCategoriesTableBody">
                <tr><td colspan="4">جاري تحميل التصنيفات...</td></tr>
            </tbody>
        </table>
    </section>

    {{-- 4) إدارة الخدمات --}}
    <section id="servicesSection" class="tab-section">
        <div class="section-header">
            <h2>الخدمات</h2>
            <p>إضافة خدمة جديدة أو إدارة الخدمات الموجودة على مستوى النظام.</p>
        </div>

        <form id="adminAddServiceForm" class="booking-form-container">
            <div class="form-row">
                <label>اسم الخدمة <span class="required">*</span></label>
                <input type="text" id="adminServiceName" required>
            </div>
            <div class="form-row">
                <label>الوصف</label>
                <textarea id="adminServiceDescription" rows="2"></textarea>
            </div>
            <div class="form-row-inline">
                <div>
                    <label>السعر الأدنى</label>
                    <input type="number" id="adminServicePriceMin" min="0">
                </div>
                <div>
                    <label>السعر الأعلى</label>
                    <input type="number" id="adminServicePriceMax" min="0">
                </div>
                <div>
                    <label>المدة (بالدقائق)</label>
                    <input type="number" id="adminServiceDuration" min="1">
                </div>
            </div>
            <div class="form-row-inline">
                <div>
                    <label>ID المزوّد</label>
                    <input type="number" id="adminServiceProviderId" min="1"
                           placeholder="ID من جدول users (role = provider)">
                </div>
                <div>
                    <label>ID التصنيف</label>
                    <input type="number" id="adminServiceCategoryId" min="1"
                           placeholder="ID من جدول service_categories">
                </div>
                <div>
                    <label>
                        <input type="checkbox" id="adminServiceIsActive" checked>
                        مفعّل
                    </label>
                </div>
            </div>
            <button type="submit" class="btn-primary-small">إضافة خدمة</button>
        </form>

        <h3 style="margin-top:16px;">قائمة الخدمات</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>المزوّد</th>
                    <th>التصنيف</th>
                    <th>السعر</th>
                    <th>مفعّل؟</th>
                    <th>إجراء</th>
                </tr>
            </thead>
            <tbody id="adminServicesTableBody">
                <tr><td colspan="7">جاري تحميل الخدمات...</td></tr>
            </tbody>
        </table>
    </section>

    {{-- 5) تقارير الحجوزات --}}
    <section id="bookingsSection" class="tab-section">
        <div class="section-header">
            <h2>تقارير الحجوزات</h2>
            <p>إحصائيات عامة وجميع الحجوزات مرتبة حسب التاريخ.</p>
        </div>

        <div id="adminBookingStats" class="stats-grid">
            {{-- تعبئة JS --}}
        </div>

        <h3 style="margin-top:16px;">جميع الحجوزات</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>العميل</th>
                    <th>المزوّد</th>
                    <th>الخدمة</th>
                    <th>التاريخ</th>
                    <th>الوقت</th>
                    <th>الحالة</th>
                </tr>
            </thead>
            <tbody id="adminBookingsTableBody">
                <tr><td colspan="7">جاري تحميل الحجوزات...</td></tr>
            </tbody>
        </table>
    </section>

    {{-- 6) مراجعة التقييمات --}}
    <section id="reviewsSection" class="tab-section">
        <div class="section-header">
            <h2>التقييمات</h2>
            <p>عرض جميع التقييمات مع إمكانية حذف التقييمات المسيئة.</p>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>العميل</th>
                    <th>المزوّد</th>
                    <th>الخدمة</th>
                    <th>التقييم</th>
                    <th>التعليق</th>
                    <th>حذف</th>
                </tr>
            </thead>
            <tbody id="adminReviewsTableBody">
                <tr><td colspan="7">جاري تحميل التقييمات...</td></tr>
            </tbody>
        </table>
    </section>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const token = localStorage.getItem('auth_token');
    const alertBox = document.getElementById('adminAlert');

    if (!token) {
        window.location.href = '/login';
        return;
    }

    function showError(msg) {
        alertBox.style.display = 'block';
        alertBox.innerHTML = msg;
    }
    function clearError() {
        alertBox.style.display = 'none';
        alertBox.innerHTML = '';
    }

    function authHeaders() {
        return {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + token,
        };
    }

    // 0) تأكيد أن المستخدم Admin
    async function loadMe() {
        try {
            const res = await fetch('/api/me', {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token,
                },
            });
            if (res.status === 401 || res.status === 403) {
                localStorage.removeItem('auth_token');
                window.location.href = '/login';
                return;
            }
            const user = await res.json();
            if (user.role !== 'admin') {
                // لو مو أدمن → رجعيه حسب دوره
                if (user.role === 'customer') {
                    window.location.href = '/customer';
                } else if (user.role === 'provider') {
                    window.location.href = '/provider';
                } else {
                    window.location.href = '/login';
                }
                return;
            }
            document.getElementById('adminNameBadge').textContent = 'مشرف: ' + (user.name || '');
        } catch (e) {
            showError('تعذر تحميل بيانات المستخدم.');
        }
    }

    // تبويبات
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabSections = document.querySelectorAll('.tab-section');

    tabButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.dataset.target;
            tabButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            tabSections.forEach(sec => {
                if (sec.id === target) sec.classList.add('active');
                else sec.classList.remove('active');
            });

            // تحميل البيانات الخاصة بكل تبويب عند فتحه
            if (target === 'usersSection') loadUsers();
            if (target === 'providersSection') loadProviders();
            if (target === 'categoriesSection') loadCategories();
            if (target === 'servicesSection') loadServices();
            if (target === 'bookingsSection') loadBookingReport();
            if (target === 'reviewsSection') loadReviews();
        });
    });

    // ===============================
    // 1) المستخدمون
    // ===============================
    const usersTableBody = document.getElementById('adminUsersTableBody');

    async function loadUsers() {
        clearError();
        usersTableBody.innerHTML = '<tr><td colspan="6">جاري التحميل...</td></tr>';

        try {
            const res = await fetch('/api/admin/users', {
                headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token }
            });
            const data = await res.json();
            if (!res.ok) {
                usersTableBody.innerHTML = '<tr><td colspan="6">فشل تحميل المستخدمين.</td></tr>';
                showError(data.message || 'خطأ في تحميل المستخدمين.');
                return;
            }

            const users = data || [];
            if (!users.length) {
                usersTableBody.innerHTML = '<tr><td colspan="6">لا يوجد مستخدمون.</td></tr>';
                return;
            }

            usersTableBody.innerHTML = '';
            users.forEach((u, index) => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${u.name ?? '-'}</td>
                    <td>${u.email ?? '-'}</td>
                    <td>${u.role ?? '-'}</td>
                    <td>${u.status ?? '-'}</td>
                    <td>
                        <button class="btn-primary-small" data-id="${u.id}" data-status="${u.status}">
                            تبديل الحالة
                        </button>
                    </td>
                `;
                usersTableBody.appendChild(tr);
            });

            usersTableBody.querySelectorAll('button').forEach(btn => {
                btn.addEventListener('click', async () => {
                    const id = btn.dataset.id;
                    await toggleUserStatus(id);
                });
            });

        } catch (e) {
            usersTableBody.innerHTML = '<tr><td colspan="6">خطأ في الاتصال بالخادم.</td></tr>';
        }
    }

    async function toggleUserStatus(id) {
        clearError();
        try {
            const res = await fetch(`/api/admin/users/${id}/toggle-status`, {
                method: 'PATCH',
                headers: authHeaders(),
            });
            const data = await res.json();
            if (!res.ok) {
                showError(data.message || 'فشل تحديث حالة المستخدم.');
            } else {
                alert(data.message || 'تم تحديث الحالة بنجاح.');
                loadUsers();
            }
        } catch (e) {
            showError('خطأ في الاتصال أثناء تحديث الحالة.');
        }
    }

    // ===============================
    // 2) مزوّدو الخدمات
    // ===============================
    const providersTableBody = document.getElementById('adminProvidersTableBody');

    async function loadProviders() {
        clearError();
        providersTableBody.innerHTML = '<tr><td colspan="6">جاري التحميل...</td></tr>';

        try {
            const res = await fetch('/api/admin/providers', {
                headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token }
            });
            const data = await res.json();

            if (!res.ok) {
                providersTableBody.innerHTML = '<tr><td colspan="6">فشل تحميل مزوّدي الخدمات.</td></tr>';
                showError(data.message || 'خطأ في تحميل مزوّدي الخدمات.');
                return;
            }

            const providers = data || [];
            if (!providers.length) {
                providersTableBody.innerHTML = '<tr><td colspan="6">لا يوجد مزوّدو خدمات.</td></tr>';
                return;
            }

            providersTableBody.innerHTML = '';
            providers.forEach((p, index) => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${p.name ?? '-'}</td>
                    <td>${p.email ?? '-'}</td>
                    <td>${p.location_city ?? '-'}</td>
                    <td>${p.status ?? '-'}</td>
                    <td>
                        <button class="btn-primary-small btn-toggle-provider" data-id="${p.id}">
                            تبديل الحالة
                        </button>
                        <button class="btn-danger-link btn-link btn-delete-provider" data-id="${p.id}">
                            حذف
                        </button>
                    </td>
                `;
                providersTableBody.appendChild(tr);
            });

            providersTableBody.querySelectorAll('.btn-toggle-provider').forEach(btn => {
                btn.addEventListener('click', () => toggleProviderStatus(btn.dataset.id));
            });

            providersTableBody.querySelectorAll('.btn-delete-provider').forEach(btn => {
                btn.addEventListener('click', () => deleteProvider(btn.dataset.id));
            });

        } catch (e) {
            providersTableBody.innerHTML = '<tr><td colspan="6">خطأ في الاتصال بالخادم.</td></tr>';
        }
    }

    async function toggleProviderStatus(id) {
        clearError();
        try {
            const res = await fetch(`/api/admin/providers/${id}/toggle-status`, {
                method: 'PATCH',
                headers: authHeaders(),
            });
            const data = await res.json();
            if (!res.ok) {
                showError(data.message || 'فشل تحديث حالة المزوّد.');
            } else {
                alert(data.message || 'تم تحديث حالة المزوّد.');
                loadProviders();
            }
        } catch (e) {
            showError('خطأ في الاتصال أثناء تحديث حالة المزوّد.');
        }
    }

    async function deleteProvider(id) {
        if (!confirm('هل أنت متأكد من حذف هذا المزوّد؟')) return;
        clearError();
        try {
            const res = await fetch(`/api/admin/providers/${id}`, {
                method: 'DELETE',
                headers: authHeaders(),
            });
            const data = await res.json();
            if (!res.ok) {
                showError(data.message || 'فشل حذف المزوّد.');
            } else {
                alert(data.message || 'تم حذف المزوّد بنجاح.');
                loadProviders();
            }
        } catch (e) {
            showError('خطأ في الاتصال أثناء حذف المزوّد.');
        }
    }

    // ===============================
    // 3) التصنيفات
    // ===============================
    const categoriesTableBody = document.getElementById('adminCategoriesTableBody');
    const addCategoryForm = document.getElementById('adminAddCategoryForm');

    addCategoryForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        clearError();

        const name = document.getElementById('adminCategoryName').value.trim();
        if (!name) {
            showError('الرجاء إدخال اسم التصنيف.');
            return;
        }

        try {
            const res = await fetch('/api/admin/categories', {
                method: 'POST',
                headers: authHeaders(),
                body: JSON.stringify({ name }),
            });
            const data = await res.json();
            if (!res.ok) {
                showError(data.message || 'فشل إضافة التصنيف.');
            } else {
                alert(data.message || 'تمت إضافة التصنيف.');
                addCategoryForm.reset();
                loadCategories();
            }
        } catch (e) {
            showError('خطأ في الاتصال أثناء إضافة التصنيف.');
        }
    });

    async function loadCategories() {
        clearError();
        categoriesTableBody.innerHTML = '<tr><td colspan="4">جاري التحميل...</td></tr>';

        try {
            const res = await fetch('/api/admin/categories', {
                headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token }
            });
            const data = await res.json();
            if (!res.ok) {
                categoriesTableBody.innerHTML = '<tr><td colspan="4">فشل تحميل التصنيفات.</td></tr>';
                showError(data.message || 'خطأ في تحميل التصنيفات.');
                return;
            }

            const categories = data || [];
            if (!categories.length) {
                categoriesTableBody.innerHTML = '<tr><td colspan="4">لا توجد تصنيفات.</td></tr>';
                return;
            }

            categoriesTableBody.innerHTML = '';
            categories.forEach((c, index) => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${c.name ?? '-'}</td>
                    <td>
                        <input type="text" value="${c.name ?? ''}" data-id="${c.id}"
                               class="admin-category-edit-input">
                        <button class="btn-primary-small admin-category-save" data-id="${c.id}">
                            حفظ
                        </button>
                    </td>
                    <td>
                        <button class="btn-danger-link btn-link admin-category-delete" data-id="${c.id}">
                            حذف
                        </button>
                    </td>
                `;
                categoriesTableBody.appendChild(tr);
            });

            categoriesTableBody.querySelectorAll('.admin-category-save').forEach(btn => {
                btn.addEventListener('click', async () => {
                    const id = btn.dataset.id;
                    const input = categoriesTableBody.querySelector(`input[data-id="${id}"]`);
                    const newName = input.value.trim();
                    if (!newName) {
                        showError('اسم التصنيف لا يمكن أن يكون فارغاً.');
                        return;
                    }
                    await updateCategory(id, newName);
                });
            });

            categoriesTableBody.querySelectorAll('.admin-category-delete').forEach(btn => {
                btn.addEventListener('click', async () => {
                    const id = btn.dataset.id;
                    await deleteCategory(id);
                });
            });

        } catch (e) {
            categoriesTableBody.innerHTML = '<tr><td colspan="4">خطأ في الاتصال بالخادم.</td></tr>';
        }
    }

    async function updateCategory(id, name) {
        clearError();
        try {
            const res = await fetch(`/api/admin/categories/${id}`, {
                method: 'PUT',
                headers: authHeaders(),
                body: JSON.stringify({ name }),
            });
            const data = await res.json();
            if (!res.ok) {
                showError(data.message || 'فشل تحديث التصنيف.');
            } else {
                alert(data.message || 'تم تحديث التصنيف.');
                loadCategories();
            }
        } catch (e) {
            showError('خطأ في الاتصال أثناء تحديث التصنيف.');
        }
    }

    async function deleteCategory(id) {
        if (!confirm('هل أنت متأكد من حذف هذا التصنيف؟')) return;
        clearError();
        try {
            const res = await fetch(`/api/admin/categories/${id}`, {
                method: 'DELETE',
                headers: authHeaders(),
            });
            const data = await res.json();
            if (!res.ok) {
                showError(data.message || 'فشل حذف التصنيف.');
            } else {
                alert(data.message || 'تم حذف التصنيف.');
                loadCategories();
            }
        } catch (e) {
            showError('خطأ في الاتصال أثناء حذف التصنيف.');
        }
    }

    // ===============================
    // 4) الخدمات
    // ===============================
    const servicesTableBody = document.getElementById('adminServicesTableBody');
    const addServiceForm = document.getElementById('adminAddServiceForm');

    addServiceForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        clearError();

        const payload = {
            name: document.getElementById('adminServiceName').value.trim(),
            description: document.getElementById('adminServiceDescription').value || null,
            price_min: parseFloat(document.getElementById('adminServicePriceMin').value || 0),
            price_max: parseFloat(document.getElementById('adminServicePriceMax').value || 0),
            duration_minutes: parseInt(document.getElementById('adminServiceDuration').value || 30),
            provider_id: parseInt(document.getElementById('adminServiceProviderId').value || 0),
            category_id: parseInt(document.getElementById('adminServiceCategoryId').value || 0),
            is_active: document.getElementById('adminServiceIsActive').checked,
        };

        if (!payload.name || !payload.provider_id || !payload.category_id) {
            showError('اسم الخدمة و ID المزوّد و ID التصنيف حقول مطلوبة.');
            return;
        }

        try {
            const res = await fetch('/api/admin/services', {
                method: 'POST',
                headers: authHeaders(),
                body: JSON.stringify(payload),
            });
            const data = await res.json();
            if (!res.ok) {
                showError(data.message || 'فشل إضافة الخدمة.');
            } else {
                alert(data.message || 'تمت إضافة الخدمة.');
                addServiceForm.reset();
                document.getElementById('adminServiceIsActive').checked = true;
                loadServices();
            }
        } catch (e) {
            showError('خطأ في الاتصال أثناء إضافة الخدمة.');
        }
    });

    async function loadServices() {
        clearError();
        servicesTableBody.innerHTML = '<tr><td colspan="7">جاري التحميل...</td></tr>';

        try {
            const res = await fetch('/api/admin/services', {
                headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token }
            });
            const data = await res.json();
            if (!res.ok) {
                servicesTableBody.innerHTML = '<tr><td colspan="7">فشل تحميل الخدمات.</td></tr>';
                showError(data.message || 'خطأ في تحميل الخدمات.');
                return;
            }

            const services = data || [];
            if (!services.length) {
                servicesTableBody.innerHTML = '<tr><td colspan="7">لا توجد خدمات.</td></tr>';
                return;
            }

            servicesTableBody.innerHTML = '';
            services.forEach((s, index) => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${s.name ?? '-'}</td>
                    <td>${s.provider?.name ?? '-'}</td>
                    <td>${s.category?.name ?? '-'}</td>
                    <td>${(s.price_min ?? '-') + ' - ' + (s.price_max ?? '-') }</td>
                    <td>
                        <select class="admin-service-active-select" data-id="${s.id}">
                            <option value="1" ${s.is_active ? 'selected' : ''}>مفعّل</option>
                            <option value="0" ${!s.is_active ? 'selected' : ''}>موقوف</option>
                        </select>
                    </td>
                    <td>
                        <button class="btn-primary-small admin-service-save" data-id="${s.id}">
                            حفظ
                        </button>
                        <button class="btn-danger-link btn-link admin-service-delete" data-id="${s.id}">
                            حذف
                        </button>
                    </td>
                `;
                servicesTableBody.appendChild(tr);
            });

            servicesTableBody.querySelectorAll('.admin-service-save').forEach(btn => {
                btn.addEventListener('click', async () => {
                    const id = btn.dataset.id;
                    const select = servicesTableBody.querySelector(`.admin-service-active-select[data-id="${id}"]`);
                    const isActive = select.value === '1';
                    await updateServiceStatus(id, isActive);
                });
            });

            servicesTableBody.querySelectorAll('.admin-service-delete').forEach(btn => {
                btn.addEventListener('click', () => deleteService(btn.dataset.id));
            });

        } catch (e) {
            servicesTableBody.innerHTML = '<tr><td colspan="7">خطأ في الاتصال بالخادم.</td></tr>';
        }
    }

    async function updateServiceStatus(id, isActive) {
        clearError();
        try {
            const res = await fetch(`/api/admin/services/${id}`, {
                method: 'PUT',
                headers: authHeaders(),
                body: JSON.stringify({ is_active: isActive }),
            });
            const data = await res.json();
            if (!res.ok) {
                showError(data.message || 'فشل تحديث حالة الخدمة.');
            } else {
                alert(data.message || 'تم تحديث حالة الخدمة.');
                loadServices();
            }
        } catch (e) {
            showError('خطأ في الاتصال أثناء تحديث حالة الخدمة.');
        }
    }

    async function deleteService(id) {
        if (!confirm('هل أنت متأكد من حذف هذه الخدمة؟')) return;
        clearError();
        try {
            const res = await fetch(`/api/admin/services/${id}`, {
                method: 'DELETE',
                headers: authHeaders(),
            });
            const data = await res.json();
            if (!res.ok) {
                showError(data.message || 'فشل حذف الخدمة.');
            } else {
                alert(data.message || 'تم حذف الخدمة.');
                loadServices();
            }
        } catch (e) {
            showError('خطأ في الاتصال أثناء حذف الخدمة.');
        }
    }

    // ===============================
    // 5) تقارير الحجوزات
    // ===============================
    const bookingStatsBox = document.getElementById('adminBookingStats');
    const bookingsTableBody = document.getElementById('adminBookingsTableBody');

    async function loadBookingReport() {
        clearError();
        bookingStatsBox.innerHTML = 'جاري تحميل الإحصائيات...';
        bookingsTableBody.innerHTML = '<tr><td colspan="7">جاري تحميل الحجوزات...</td></tr>';

        try {
            const res = await fetch('/api/admin/bookings/report', {
                headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token }
            });
            const data = await res.json();
            if (!res.ok) {
                bookingStatsBox.innerHTML = 'فشل تحميل الإحصائيات.';
                bookingsTableBody.innerHTML = '<tr><td colspan="7">فشل تحميل الحجوزات.</td></tr>';
                showError(data.message || 'خطأ في تحميل تقارير الحجوزات.');
                return;
            }

            const stats = data.stats || {};
            const bookings = data.bookings || [];

            bookingStatsBox.innerHTML = `
                <div class="stat-card">إجمالي الحجوزات: ${stats.total ?? 0}</div>
                <div class="stat-card">قيد الانتظار: ${stats.pending ?? 0}</div>
                <div class="stat-card">مقبولة (accepted): ${stats.accepted ?? 0}</div>
                <div class="stat-card">مرفوضة: ${stats.rejected ?? 0}</div>
                <div class="stat-card">ملغاة: ${stats.cancelled ?? 0}</div>
            `;

            if (!bookings.length) {
                bookingsTableBody.innerHTML = '<tr><td colspan="7">لا توجد حجوزات.</td></tr>';
                return;
            }

            bookingsTableBody.innerHTML = '';
            bookings.forEach((b, index) => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${b.customer?.name ?? '-'}</td>
                    <td>${b.provider?.name ?? '-'}</td>
                    <td>${b.service?.name ?? '-'}</td>
                    <td>${b.date ?? '-'}</td>
                    <td>${b.start_time ?? '-'}</td>
                    <td>${b.status ?? '-'}</td>
                `;
                bookingsTableBody.appendChild(tr);
            });

        } catch (e) {
            bookingStatsBox.innerHTML = 'خطأ في الاتصال بالخادم.';
            bookingsTableBody.innerHTML = '<tr><td colspan="7">خطأ في الاتصال بالخادم.</td></tr>';
        }
    }

    // ===============================
    // 6) التقييمات
    // ===============================
    const reviewsTableBody = document.getElementById('adminReviewsTableBody');

    async function loadReviews() {
        clearError();
        reviewsTableBody.innerHTML = '<tr><td colspan="7">جاري التحميل...</td></tr>';

        try {
            const res = await fetch('/api/admin/reviews', {
                headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token }
            });
            const data = await res.json();
            if (!res.ok) {
                reviewsTableBody.innerHTML = '<tr><td colspan="7">فشل تحميل التقييمات.</td></tr>';
                showError(data.message || 'خطأ في تحميل التقييمات.');
                return;
            }

            const reviews = data || [];
            if (!reviews.length) {
                reviewsTableBody.innerHTML = '<tr><td colspan="7">لا توجد تقييمات.</td></tr>';
                return;
            }

            reviewsTableBody.innerHTML = '';
            reviews.forEach((r, index) => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${r.customer?.name ?? '-'}</td>
                    <td>${r.provider?.name ?? '-'}</td>
                    <td>${r.service?.name ?? '-'}</td>
                    <td>${r.rating ?? '-'}</td>
                    <td>${r.comment ?? ''}</td>
                    <td>
                        <button class="btn-danger-link btn-link admin-review-delete" data-id="${r.id}">
                            حذف
                        </button>
                    </td>
                `;
                reviewsTableBody.appendChild(tr);
            });

            reviewsTableBody.querySelectorAll('.admin-review-delete').forEach(btn => {
                btn.addEventListener('click', () => deleteReview(btn.dataset.id));
            });

        } catch (e) {
            reviewsTableBody.innerHTML = '<tr><td colspan="7">خطأ في الاتصال بالخادم.</td></tr>';
        }
    }

    async function deleteReview(id) {
        if (!confirm('هل أنت متأكد من حذف هذا التقييم؟')) return;
        clearError();
        try {
            const res = await fetch(`/api/admin/reviews/${id}`, {
                method: 'DELETE',
                headers: authHeaders(),
            });
            const data = await res.json();
            if (!res.ok) {
                showError(data.message || 'فشل حذف التقييم.');
            } else {
                alert(data.message || 'تم حذف التقييم.');
                loadReviews();
            }
        } catch (e) {
            showError('خطأ في الاتصال أثناء حذف التقييم.');
        }
    }

    // تحميل أولي
    loadMe();
    loadUsers();
});
</script>
@endsection
