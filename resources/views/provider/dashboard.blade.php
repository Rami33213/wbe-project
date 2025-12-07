@extends('layouts.app')

@section('title', 'منطقة مقدّم الخدمة')

@section('content')
<div class="dashboard">
    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-title">مرحبًا، <span id="providerName">...</span></h1>
            <p class="dashboard-subtitle">
                هنا يمكنك إدارة حجوزات العملاء، مواعيد التوفر، ملفك المهني، وخدماتك.
            </p>
        </div>
        <div class="dashboard-badge" id="providerRoleBadge">مقدّم خدمة</div>
    </div>

    {{-- Tabs --}}
    <div class="tabs">
        <button class="tab-button active" data-target="providerBookingsSection">حجوزات العملاء</button>
        <button class="tab-button" data-target="availabilitySection">توفّر المواعيد</button>
        <button class="tab-button" data-target="profileSection">ملفي المهني</button>
        <button class="tab-button" data-target="servicesSection">خدماتي</button>
    </div>

    <div id="providerAlert" class="auth-alert auth-alert-error" style="display:none;"></div>

    {{-- 1) حجوزات العملاء --}}
    <section id="providerBookingsSection" class="tab-section active">
        <div class="section-header">
            <h2>حجوزات العملاء</h2>
            <p>استعرض الحجوزات الواردة من العملاء، ثم غيّر حالتها (موافقة / رفض / إكمال).</p>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>العميل</th>
                    <th>الخدمة</th>
                    <th>التاريخ</th>
                    <th>الوقت</th>
                    <th>الحالة الحالية</th>
                    <th>تغيير الحالة</th>
                </tr>
            </thead>
            <tbody id="providerBookingsTableBody">
                {{-- من /api/provider/bookings --}}
            </tbody>
        </table>
    </section>

    {{-- 2) توفّر المواعيد --}}
    <section id="availabilitySection" class="tab-section">
        <div class="section-header">
            <h2>توفّر المواعيد</h2>
            <p>ضبط الأوقات التي تكون فيها متاحًا لاستقبال حجوزات جديدة.</p>
        </div>

        <form id="availabilityForm" class="auth-form booking-form-container">
            <div class="form-row">
                <label for="availDate">التاريخ <span class="required">*</span></label>
                <input type="date" id="availDate" required>
            </div>
            <div class="form-row">
                <label for="availStart">وقت البداية <span class="required">*</span></label>
                <input type="time" id="availStart" required>
            </div>
            <div class="form-row">
                <label for="availEnd">وقت الانتهاء <span class="required">*</span></label>
                <input type="time" id="availEnd" required>
            </div>
            <button type="submit" class="btn-primary" id="availSubmitBtn">إضافة الموعد</button>
        </form>

        <h3 style="margin-top:16px;">مواعيدي المتاحة</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>التاريخ</th>
                    <th>وقت البداية</th>
                    <th>وقت الانتهاء</th>
                    <th>إجراء</th>
                </tr>
            </thead>
            <tbody id="availabilityTableBody">
                {{-- من /api/provider/availability --}}
            </tbody>
        </table>
    </section>

    {{-- 3) ملفي المهني --}}
    <section id="profileSection" class="tab-section">
        <div class="section-header">
            <h2>ملفي المهني</h2>
            <p>وصف عنك، سنوات الخبرة، السعر الأساسي، والمناطق المغطاة.</p>
        </div>

        <form id="providerProfileForm" class="auth-form booking-form-container">
            <div class="form-row">
                <label for="profileBio">نبذة تعريفية</label>
                <textarea id="profileBio" rows="3" placeholder="مثال: فني كهرباء بخبرة 8 سنوات..."></textarea>
            </div>

            <div class="form-row">
                <label for="profileExperience">سنوات الخبرة</label>
                <input type="number" id="profileExperience" min="0" max="50">
            </div>

            <div class="form-row">
                <label for="profileBasePrice">السعر الأساسي (ابتداءً من)</label>
                <input type="number" id="profileBasePrice" min="0">
            </div>

            <div class="form-row">
                <label for="profileAreas">المناطق المغطاة (افصل بين المناطق بفاصلة ,)</label>
                <input type="text" id="profileAreas" placeholder="مثال: حي النرجس, حي الندى, حي الياسمين">
            </div>

            <div class="form-row">
                <label>
                    <input type="checkbox" id="profileIsAvailable">
                    متاح لاستقبال الحجوزات حاليًا
                </label>
            </div>

            <button type="submit" class="btn-primary" id="profileSubmitBtn">حفظ الملف المهني</button>
        </form>
    </section>

    {{-- 4) خدماتي --}}
    <section id="servicesSection" class="tab-section">
        <div class="section-header">
            <h2>خدماتي (التخصصات)</h2>
            <p>أضف أو عدّل الخدمات التي تقدّمها، مع التصنيف والأسعار.</p>
        </div>

        <div class="booking-form-container">
            <button type="button" class="btn-primary-small" id="addServiceRowBtn">إضافة خدمة جديدة</button>
        </div>

        <form id="providerServicesForm" class="booking-form-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>اسم الخدمة</th>
                        <th>ID التصنيف</th>
                        <th>السعر الأدنى</th>
                        <th>السعر الأعلى</th>
                        <th>الوصف</th>
                        <th>حذف</th>
                    </tr>
                </thead>
                <tbody id="providerServicesTableBody">
                    {{-- صفوف الخدمات --}}
                </tbody>
            </table>

            <button type="submit" class="btn-primary" id="servicesSubmitBtn" style="margin-top:10px;">
                حفظ الخدمات
            </button>
        </form>
    </section>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const token = localStorage.getItem('auth_token');
    const alertBox = document.getElementById('providerAlert');

    if (!token) {
        window.location.href = '/login';
        return;
    }

    function showError(msg) {
        if (!alertBox) return;
        alertBox.style.display = 'block';
        alertBox.innerHTML = msg;
    }
    function clearError() {
        if (!alertBox) return;
        alertBox.style.display = 'none';
        alertBox.innerHTML = '';
    }

    // 1) تحميل بيانات المستخدم والتأكد أنه provider
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
            document.getElementById('providerName').textContent = user.name || 'مستخدم';

            if (user.role !== 'provider') {
                // حماية بسيطة: لو الدور ليس مقدّم خدمة، رجّعه مثلاً على /customer أو /login
                window.location.href = user.role === 'customer' ? '/customer' : '/login';
                return;
            }

            document.getElementById('providerRoleBadge').textContent = 'مقدّم خدمة';
        } catch (e) {
            showError('فشل تحميل بيانات المستخدم.');
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

            // تحميل عند فتح التبويب
            if (target === 'providerBookingsSection') loadProviderBookings();
            if (target === 'availabilitySection') loadAvailability();
            if (target === 'profileSection') loadProviderProfile();
            if (target === 'servicesSection') loadProviderServices();
        });
    });

    // ================================
    // 2) حجوزات العملاء
    // ================================
    const providerBookingsTableBody = document.getElementById('providerBookingsTableBody');

    async function loadProviderBookings() {
        clearError();
        providerBookingsTableBody.innerHTML = '<tr><td colspan="7">جاري تحميل الحجوزات...</td></tr>';

        try {
            const res = await fetch('/api/provider/bookings', {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token,
                },
            });

            const data = await res.json();
            if (!res.ok) {
                providerBookingsTableBody.innerHTML = '<tr><td colspan="7">فشل تحميل الحجوزات.</td></tr>';
                return;
            }

            const bookings = data.bookings || [];
            if (!bookings.length) {
                providerBookingsTableBody.innerHTML = '<tr><td colspan="7">لا توجد حجوزات حالياً.</td></tr>';
                return;
            }

            providerBookingsTableBody.innerHTML = '';
            bookings.forEach((b, index) => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${b.customer?.name ?? '-'}</td>
                    <td>${b.service?.name ?? '-'}</td>
                    <td>${b.date ?? '-'}</td>
                    <td>${b.start_time ?? '-'}</td>
                    <td>${b.status ?? '-'}</td>
                    <td>
                        <select data-id="${b.id}" class="status-select">
                            <option value="pending" ${b.status === 'pending' ? 'selected' : ''}>قيد الانتظار</option>
                            <option value="confirmed" ${b.status === 'confirmed' ? 'selected' : ''}>مؤكد</option>
                            <option value="completed" ${b.status === 'completed' ? 'selected' : ''}>مكتمل</option>
                            <option value="rejected" ${b.status === 'rejected' ? 'selected' : ''}>مرفوض</option>
                        </select>
                        <button class="btn-primary-small save-status-btn" data-id="${b.id}">
                            حفظ
                        </button>
                    </td>
                `;
                providerBookingsTableBody.appendChild(tr);
            });

            // ربط الأحداث
            providerBookingsTableBody.querySelectorAll('.save-status-btn').forEach(btn => {
                btn.addEventListener('click', async () => {
                    const id = btn.dataset.id;
                    const select = providerBookingsTableBody.querySelector(`select[data-id="${id}"]`);
                    const newStatus = select.value;
                    await updateBookingStatus(id, newStatus);
                });
            });

        } catch (e) {
            providerBookingsTableBody.innerHTML = '<tr><td colspan="7">خطأ في الاتصال بالخادم.</td></tr>';
        }
    }

    async function updateBookingStatus(id, status) {
        clearError();
        try {
            const res = await fetch(`/api/provider/bookings/${id}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token,
                },
                body: JSON.stringify({ status }),
            });

            const data = await res.json();
            if (!res.ok) {
                showError(data.message || 'فشل تحديث حالة الحجز.');
            } else {
                alert(data.message || 'تم تحديث حالة الحجز بنجاح.');
                loadProviderBookings();
            }
        } catch (e) {
            showError('خطأ في الاتصال بالخادم أثناء تحديث الحالة.');
        }
    }

    // ================================
    // 3) توفّر المواعيد
    // ================================
    const availabilityForm = document.getElementById('availabilityForm');
    const availabilityTableBody = document.getElementById('availabilityTableBody');
    const availSubmitBtn = document.getElementById('availSubmitBtn');

    availabilityForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        clearError();

        const payload = {
            date: document.getElementById('availDate').value,
            start_time: document.getElementById('availStart').value,
            end_time: document.getElementById('availEnd').value,
        };

        availSubmitBtn.disabled = true;
        availSubmitBtn.textContent = 'جاري الإضافة...';

        try {
            const res = await fetch('/api/provider/availability', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token,
                },
                body: JSON.stringify(payload),
            });

            const data = await res.json();
            if (!res.ok) {
                showError(data.message || 'فشل إضافة الموعد.');
            } else {
                alert(data.message || 'تمت إضافة الموعد بنجاح.');
                availabilityForm.reset();
                loadAvailability();
            }
        } catch (e) {
            showError('خطأ في الاتصال بالخادم أثناء إضافة الموعد.');
        } finally {
            availSubmitBtn.disabled = false;
            availSubmitBtn.textContent = 'إضافة الموعد';
        }
    });

    async function loadAvailability() {
        clearError();
        availabilityTableBody.innerHTML = '<tr><td colspan="5">جاري تحميل المواعيد...</td></tr>';

        try {
            const res = await fetch('/api/provider/availability', {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token,
                },
            });

            const data = await res.json();
            if (!res.ok) {
                availabilityTableBody.innerHTML = '<tr><td colspan="5">فشل تحميل المواعيد.</td></tr>';
                return;
            }

            const slots = data.slots || [];
            if (!slots.length) {
                availabilityTableBody.innerHTML = '<tr><td colspan="5">لا يوجد مواعيد متاحة حالياً.</td></tr>';
                return;
            }

            availabilityTableBody.innerHTML = '';
            slots.forEach((s, index) => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${s.date}</td>
                    <td>${s.start_time}</td>
                    <td>${s.end_time}</td>
                    <td>
                        <button class="btn-danger-link btn-link" data-id="${s.id}">
                            حذف
                        </button>
                    </td>
                `;
                availabilityTableBody.appendChild(tr);
            });

            availabilityTableBody.querySelectorAll('button').forEach(btn => {
                btn.addEventListener('click', () => deleteSlot(btn.dataset.id));
            });

        } catch (e) {
            availabilityTableBody.innerHTML = '<tr><td colspan="5">خطأ في الاتصال بالخادم.</td></tr>';
        }
    }

    async function deleteSlot(id) {
        if (!confirm('هل أنت متأكد من حذف هذا الموعد؟')) return;
        clearError();

        try {
            const res = await fetch(`/api/provider/availability/${id}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token,
                },
            });

            const data = await res.json();
            if (!res.ok) {
                showError(data.message || 'فشل حذف الموعد.');
            } else {
                alert(data.message || 'تم حذف الموعد بنجاح.');
                loadAvailability();
            }
        } catch (e) {
            showError('خطأ في الاتصال بالخادم أثناء حذف الموعد.');
        }
    }

    // ================================
    // 4) الملف المهني
    // ================================
    const providerProfileForm = document.getElementById('providerProfileForm');
    const profileSubmitBtn = document.getElementById('profileSubmitBtn');

    async function loadProviderProfile() {
        clearError();
        // نفترض عندك راوت GET يرجع بروفايل المزود (لو ما في، بتضل الحقول فاضية وتقدري تعبّيها من جديد)
        try {
            const res = await fetch('/api/provider/profile', {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token,
                },
            });

            if (!res.ok) {
                // مو ضروري نعتبره خطأ قاتل
                return;
            }

            const data = await res.json();
            const p = data.profile || data.provider || {};

            document.getElementById('profileBio').value = p.bio ?? '';
            document.getElementById('profileExperience').value = p.years_of_experience ?? '';
            document.getElementById('profileBasePrice').value = p.base_price ?? '';
            if (Array.isArray(p.covered_areas)) {
                document.getElementById('profileAreas').value = p.covered_areas.join(', ');
            }
            document.getElementById('profileIsAvailable').checked = p.is_available ?? true;

        } catch (e) {
            // نتجاهله بصمت أو نعرض رسالة خفيفة
        }
    }

    providerProfileForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        clearError();

        const areasString = document.getElementById('profileAreas').value;
        let areasArray = [];
        if (areasString.trim() !== '') {
            areasArray = areasString.split(',').map(a => a.trim()).filter(a => a.length > 0);
        }

        const payload = {
            bio: document.getElementById('profileBio').value || null,
            years_of_experience: document.getElementById('profileExperience').value || null,
            base_price: document.getElementById('profileBasePrice').value || null,
            covered_areas: areasArray,
            is_available: document.getElementById('profileIsAvailable').checked,
        };

        profileSubmitBtn.disabled = true;
        profileSubmitBtn.textContent = 'جاري الحفظ...';

        try {
            const res = await fetch('/api/provider/profile', {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token,
                },
                body: JSON.stringify(payload),
            });

            const data = await res.json();
            if (!res.ok) {
                showError(data.message || 'فشل تحديث الملف المهني.');
            } else {
                alert(data.message || 'تم تحديث الملف المهني بنجاح.');
            }
        } catch (e) {
            showError('خطأ في الاتصال بالخادم أثناء تحديث الملف المهني.');
        } finally {
            profileSubmitBtn.disabled = false;
            profileSubmitBtn.textContent = 'حفظ الملف المهني';
        }
    });

    // ================================
    // 5) خدماتي (التخصصات)
    // ================================
    const providerServicesForm = document.getElementById('providerServicesForm');
    const providerServicesTableBody = document.getElementById('providerServicesTableBody');
    const addServiceRowBtn = document.getElementById('addServiceRowBtn');
    const servicesSubmitBtn = document.getElementById('servicesSubmitBtn');

    function addServiceRow(service = {}) {
        const tr = document.createElement('tr');

        const id = service.id ?? '';

        tr.innerHTML = `
            <td>
                <input type="hidden" class="service-id" value="${id}">
                <input type="text" class="service-name" value="${service.name ?? ''}" required>
            </td>
            <td>
                <input type="number" class="service-category" value="${service.category_id ?? ''}" required>
            </td>
            <td>
                <input type="number" class="service-price-min" value="${service.price_min ?? ''}" required min="0">
            </td>
            <td>
                <input type="number" class="service-price-max" value="${service.price_max ?? ''}" required min="0">
            </td>
            <td>
                <input type="text" class="service-description" value="${service.description ?? ''}">
            </td>
            <td>
                <button type="button" class="btn-danger-link btn-link remove-service-row">X</button>
            </td>
        `;
        providerServicesTableBody.appendChild(tr);

        tr.querySelector('.remove-service-row').addEventListener('click', function () {
            tr.remove();
        });
    }

    addServiceRowBtn.addEventListener('click', function () {
        addServiceRow();
    });

    async function loadProviderServices() {
        clearError();
        providerServicesTableBody.innerHTML = '<tr><td colspan="6">جاري تحميل الخدمات...</td></tr>';

        try {
            // نفترض عندك راوت GET /api/provider/services يرجع خدمات المزود
            const res = await fetch('/api/provider/services', {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token,
                },
            });

            const data = await res.json();
            if (!res.ok) {
                providerServicesTableBody.innerHTML = '<tr><td colspan="6">فشل تحميل الخدمات، يمكنك إضافة خدمات جديدة يدويًا.</td></tr>';
                return;
            }

            const services = data.services || data.data || [];
            if (!services.length) {
                providerServicesTableBody.innerHTML = '';
                return;
            }

            providerServicesTableBody.innerHTML = '';
            services.forEach(s => addServiceRow(s));

        } catch (e) {
            providerServicesTableBody.innerHTML = '<tr><td colspan="6">خطأ في الاتصال، يمكنك إضافة خدمات جديدة يدويًا.</td></tr>';
        }
    }

    providerServicesForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        clearError();

        const rows = providerServicesTableBody.querySelectorAll('tr');
        if (!rows.length) {
            showError('أضف خدمة واحدة على الأقل قبل الحفظ.');
            return;
        }

        const servicesPayload = [];
        let valid = true;

        rows.forEach(tr => {
            const id = tr.querySelector('.service-id').value || null;
            const name = tr.querySelector('.service-name').value.trim();
            const category_id = tr.querySelector('.service-category').value;
            const price_min = tr.querySelector('.service-price-min').value;
            const price_max = tr.querySelector('.service-price-max').value;
            const description = tr.querySelector('.service-description').value || null;

            if (!name || !category_id || !price_min || !price_max) {
                valid = false;
            }

            servicesPayload.push({
                id,
                name,
                category_id,
                price_min,
                price_max,
                description,
            });
        });

        if (!valid) {
            showError('تأكّد من تعبئة الحقول المطلوبة لكل خدمة.');
            return;
        }

        servicesSubmitBtn.disabled = true;
        servicesSubmitBtn.textContent = 'جاري حفظ الخدمات...';

        try {
            const res = await fetch('/api/provider/services', {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token,
                },
                body: JSON.stringify({ services: servicesPayload }),
            });

            const data = await res.json();
            if (!res.ok) {
                showError(data.message || 'فشل حفظ الخدمات.');
            } else {
                alert(data.message || 'تم حفظ الخدمات بنجاح.');
                // إعادة تحميل الخدمات مع الـ id الجديدة
                loadProviderServices();
            }
        } catch (e) {
            showError('خطأ في الاتصال بالخادم أثناء حفظ الخدمات.');
        } finally {
            servicesSubmitBtn.disabled = false;
            servicesSubmitBtn.textContent = 'حفظ الخدمات';
        }
    });

    // تحميل افتراضي لأول تبويب
    loadMe();
    loadProviderBookings();
});
</script>
@endsection
