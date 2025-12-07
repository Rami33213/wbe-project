@extends('layouts.app')

@section('title', 'منطقة الزبون')

@section('content')
<div class="dashboard">
    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-title">مرحبًا، <span id="customerName">...</span></h1>
            <p class="dashboard-subtitle">
                هنا يمكنك استعراض الخدمات، إنشاء حجوزات، متابعة حالتها، وإضافة تقييمات.
            </p>
        </div>
        <div class="dashboard-badge" id="customerRoleBadge">زبون</div>
    </div>

    {{-- Tabs --}}
    <div class="tabs">
        <button class="tab-button active" data-target="servicesSection">الخدمات المتاحة</button>
        <button class="tab-button" data-target="bookingsSection">حجوزاتي</button>
        <button class="tab-button" data-target="reviewsSection">تقييماتي</button>
        <button class="tab-button" data-target="notificationsSection">الإشعارات</button>
        <button class="tab-button" data-target="providersSection">بحث عن مقدمي الخدمة</button>
    </div>

    <div id="dashboardAlert" class="auth-alert auth-alert-error" style="display:none;"></div>

    {{-- 1) قسم الخدمات --}}
    <section id="servicesSection" class="tab-section active">
        <div class="section-header">
            <h2>الخدمات المتاحة</h2>
            <p>استخدم الفلاتر لاختيار الخدمة المناسبة حسب المدينة، التصنيف، والسعر.</p>
        </div>

        <form id="servicesFilterForm" class="filter-form">
            <div class="form-row-inline">
                <div>
                    <label>المدينة</label>
                    <input type="text" id="filterCity" placeholder="مثال: الرياض">
                </div>
                <div>
                    <label>التصنيف (ID)</label>
                    <input type="number" id="filterCategoryId" min="1" placeholder="مثال: 1">
                </div>
                <div>
                    <label>السعر الأدنى</label>
                    <input type="number" id="filterPriceMin" min="0">
                </div>
                <div>
                    <label>السعر الأعلى</label>
                    <input type="number" id="filterPriceMax" min="0">
                </div>
            </div>
            <button type="submit" class="btn-primary-small">تطبيق الفلتر</button>
        </form>

        <div id="servicesList" class="cards-grid">
            {{-- الخدمات تأتي من API --}}
        </div>

        {{-- فورم حجز خدمة معينة --}}
        <div id="bookingFormContainer" class="booking-form-container" style="display:none;">
            <h3>حجز خدمة</h3>
            <p id="bookingServiceInfo" class="small-muted"></p>

            <form id="bookingForm" class="auth-form">
                <input type="hidden" id="bookingServiceId">
                <input type="hidden" id="bookingProviderId">

                <div class="form-row">
                    <label for="bookingDate">تاريخ الحجز <span class="required">*</span></label>
                    <input type="date" id="bookingDate" required>
                </div>

                <div class="form-row">
                    <label for="bookingStartTime">وقت البداية <span class="required">*</span></label>
                    <input type="time" id="bookingStartTime" required>
                </div>

                <div class="form-row">
                    <label for="bookingEndTime">وقت الانتهاء (اختياري)</label>
                    <input type="time" id="bookingEndTime">
                </div>

                <div class="form-row">
                    <label for="bookingNotes">ملاحظات إضافية</label>
                    <textarea id="bookingNotes" rows="3" placeholder="مثال: الشقة غرفتين وصالة..."></textarea>
                </div>

                <button type="submit" class="btn-primary" id="bookingSubmitBtn">تأكيد الحجز</button>
                <button type="button" class="btn-secondary" id="bookingCancelBtn">إلغاء</button>
            </form>
        </div>
    </section>

    {{-- 2) قسم حجوزاتي --}}
    <section id="bookingsSection" class="tab-section">
        <div class="section-header">
            <h2>حجوزاتي</h2>
            <p>تابع حالة الحجوزات، اعرض التفاصيل، أو قم بالإلغاء حسب السياسة.</p>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الخدمة</th>
                    <th>مقدّم الخدمة</th>
                    <th>التاريخ</th>
                    <th>الوقت</th>
                    <th>الحالة</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody id="bookingsTableBody">
                {{-- من API --}}
            </tbody>
        </table>

        <div id="bookingDetails" class="booking-details" style="display:none;">
            <h3>تفاصيل الحجز</h3>
            <div id="bookingDetailsContent"></div>
        </div>

        {{-- فورم تقييم خدمة بناءً على حجز --}}
        <div id="reviewFormContainer" class="booking-form-container" style="display:none;">
            <h3>تقييم الخدمة</h3>
            <p id="reviewBookingInfo" class="small-muted"></p>

            <form id="reviewForm" class="auth-form">
                <input type="hidden" id="reviewBookingId">

                <div class="form-row">
                    <label>التقييم (1 إلى 5 نجوم) <span class="required">*</span></label>
                    <select id="reviewRating" required>
                        <option value="">اختر التقييم</option>
                        <option value="1">⭐</option>
                        <option value="2">⭐⭐</option>
                        <option value="3">⭐⭐⭐</option>
                        <option value="4">⭐⭐⭐⭐</option>
                        <option value="5">⭐⭐⭐⭐⭐</option>
                    </select>
                </div>

                <div class="form-row">
                    <label>تعليقك على الخدمة</label>
                    <textarea id="reviewComment" rows="3" placeholder="شارك تجربتك مع مقدّم الخدمة..."></textarea>
                </div>

                <button type="submit" class="btn-primary" id="reviewSubmitBtn">إرسال التقييم</button>
                <button type="button" class="btn-secondary" id="reviewCancelBtn">إلغاء</button>
            </form>
        </div>
    </section>

    {{-- 3) قسم تقييماتي --}}
    <section id="reviewsSection" class="tab-section">
        <div class="section-header">
            <h2>تقييماتي</h2>
            <p>كل التقييمات التي قمت بإضافتها على الحجوزات السابقة.</p>
        </div>

        <div id="reviewsList" class="cards-grid">
            {{-- من /api/customer/reviews --}}
        </div>
    </section>

    {{-- 4) قسم الإشعارات --}}
    <section id="notificationsSection" class="tab-section">
        <div class="section-header">
            <h2>الإشعارات</h2>
            <p>آخر التحديثات على حجوزاتك من الموافقات والرفض والتغييرات.</p>
        </div>

        <ul id="notificationsList" class="notifications-list">
            {{-- من /api/customer/notifications --}}
        </ul>
    </section>

    {{-- 5) قسم بحث عن مقدمي الخدمة --}}
    <section id="providersSection" class="tab-section">
        <div class="section-header">
            <h2>بحث عن مقدمي الخدمة</h2>
            <p>ابحث عن مقدمي خدمة حسب المدينة، نوع الخدمة، أو كلمات مفتاحية.</p>
        </div>

        <form id="providersSearchForm" class="filter-form">
            <div class="form-row-inline">
                <div>
                    <label>المدينة</label>
                    <input type="text" id="providerCity" placeholder="مثال: الدمام">
                </div>
                <div>
                    <label>نوع الخدمة (ID أو اسم)</label>
                    <input type="text" id="providerService" placeholder="مثال: cleaning أو 1">
                </div>
                <div>
                    <label>كلمة مفتاحية</label>
                    <input type="text" id="providerKeyword" placeholder="مثال: خبرة، سباكة...">
                </div>
            </div>
            <button type="submit" class="btn-primary-small">بحث</button>
        </form>

        <div id="providersList" class="cards-grid">
            {{-- من /api/customer/providers/search --}}
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const token = localStorage.getItem('auth_token');
    const alertBox = document.getElementById('dashboardAlert');

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

    // 1) تحميل بيانات المستخدم /me
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
            document.getElementById('customerName').textContent = user.name || 'مستخدم';
            document.getElementById('customerRoleBadge').textContent =
                user.role === 'provider' ? 'مقدّم خدمة' :
                user.role === 'admin' ? 'مشرف' : 'زبون';
        } catch (e) {
            showError('فشل تحميل بيانات المستخدم.');
        }
    }

    // 2) تبويبات
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

            // تحميل القسم عند الحاجة
            if (target === 'servicesSection') loadServices();
            if (target === 'bookingsSection') loadBookings();
            if (target === 'reviewsSection') loadReviews();
            if (target === 'notificationsSection') loadNotifications();
        });
    });

    // 3) الخدمات + الحجز
    const servicesList = document.getElementById('servicesList');
    const servicesFilterForm = document.getElementById('servicesFilterForm');

    async function loadServices() {
        clearError();
        servicesList.innerHTML = '<p>جاري تحميل الخدمات...</p>';

        const params = new URLSearchParams();
        const city = document.getElementById('filterCity').value;
        const catId = document.getElementById('filterCategoryId').value;
        const priceMin = document.getElementById('filterPriceMin').value;
        const priceMax = document.getElementById('filterPriceMax').value;

        if (city) params.append('city', city);
        if (catId) params.append('category_id', catId);
        if (priceMin) params.append('price_min', priceMin);
        if (priceMax) params.append('price_max', priceMax);

        try {
            // ⚠️ نفترض عندك route API مثل:
            // Route::get('/customer/services', [CustomerServiceController::class, 'index']);
            const res = await fetch('/api/customer/services?' + params.toString(), {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token,
                },
            });

            if (!res.ok) {
                servicesList.innerHTML = '<p>فشل تحميل الخدمات.</p>';
                return;
            }

            const data = await res.json();
            const services = data.services?.data || data.services || [];

            if (!services.length) {
                servicesList.innerHTML = '<p>لا توجد خدمات مطابقة للفلتر.</p>';
                return;
            }

            servicesList.innerHTML = '';
            services.forEach(service => {
                const card = document.createElement('div');
                card.className = 'card';

                const provider = service.provider || {};
                const category = service.category || {};

                card.innerHTML = `
                    <h3>${service.name ?? 'خدمة بدون اسم'}</h3>
                    <p class="small-muted">
                        التصنيف: ${category.name ?? 'غير محدد'}<br>
                        مقدّم الخدمة: ${provider.name ?? 'غير متوفر'}<br>
                        المدينة: ${provider.location_city ?? 'غير محددة'}
                    </p>
                    <p class="price-range">
                        السعر التقريبي:
                        ${service.price_min ?? '-'} إلى ${service.price_max ?? '-'} ريال
                    </p>
                    <button class="btn-primary-small book-service-btn"
                        data-service-id="${service.id}"
                        data-provider-id="${service.provider_id}"
                        data-service-name="${service.name ?? ''}"
                        data-provider-name="${provider.name ?? ''}">
                        حجز هذه الخدمة
                    </button>
                `;

                servicesList.appendChild(card);
            });

            document.querySelectorAll('.book-service-btn').forEach(btn => {
                btn.addEventListener('click', () => openBookingForm(btn.dataset));
            });

        } catch (e) {
            servicesList.innerHTML = '<p>خطأ في الاتصال بالخادم.</p>';
        }
    }

    servicesFilterForm.addEventListener('submit', function (e) {
        e.preventDefault();
        loadServices();
    });

    // فورم الحجز
    const bookingFormContainer = document.getElementById('bookingFormContainer');
    const bookingServiceInfo = document.getElementById('bookingServiceInfo');
    const bookingForm = document.getElementById('bookingForm');
    const bookingCancelBtn = document.getElementById('bookingCancelBtn');
    const bookingSubmitBtn = document.getElementById('bookingSubmitBtn');

    function openBookingForm(data) {
        document.getElementById('bookingServiceId').value = data.serviceId;
        document.getElementById('bookingProviderId').value = data.providerId;
        bookingServiceInfo.innerHTML = `
            حجز خدمة: <strong>${data.serviceName}</strong> مع
            <strong>${data.providerName}</strong>
        `;
        bookingFormContainer.style.display = 'block';
        bookingForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    bookingCancelBtn.addEventListener('click', function () {
        bookingFormContainer.style.display = 'none';
        bookingForm.reset();
    });

    bookingForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        clearError();

        const payload = {
            service_id: document.getElementById('bookingServiceId').value,
            provider_id: document.getElementById('bookingProviderId').value,
            date: document.getElementById('bookingDate').value,
            start_time: document.getElementById('bookingStartTime').value,
            end_time: document.getElementById('bookingEndTime').value || null,
            notes: document.getElementById('bookingNotes').value || null,
        };

        bookingSubmitBtn.disabled = true;
        bookingSubmitBtn.textContent = 'جاري إنشاء الحجز...';

        try {
            const res = await fetch('/api/customer/bookings', {
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
                showError(data.message || 'فشل إنشاء الحجز.');
            } else {
                alert('تم إنشاء الحجز بنجاح.');
                bookingFormContainer.style.display = 'none';
                bookingForm.reset();
                loadBookings();
                // ممكن نحول تلقائياً لتبويب الحجوزات
            }
        } catch (e) {
            showError('خطأ في الاتصال بالخادم أثناء إنشاء الحجز.');
        } finally {
            bookingSubmitBtn.disabled = false;
            bookingSubmitBtn.textContent = 'تأكيد الحجز';
        }
    });

    // 4) حجوزاتي
    const bookingsTableBody = document.getElementById('bookingsTableBody');
    const bookingDetails = document.getElementById('bookingDetails');
    const bookingDetailsContent = document.getElementById('bookingDetailsContent');

    async function loadBookings() {
        clearError();
        bookingsTableBody.innerHTML = '<tr><td colspan="7">جاري تحميل الحجوزات...</td></tr>';

        try {
            const res = await fetch('/api/customer/bookings', {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token,
                },
            });

            if (!res.ok) {
                bookingsTableBody.innerHTML = '<tr><td colspan="7">فشل تحميل الحجوزات.</td></tr>';
                return;
            }

            const data = await res.json();
            const bookings = data.bookings || [];

            if (!bookings.length) {
                bookingsTableBody.innerHTML = '<tr><td colspan="7">لا توجد حجوزات حتى الآن.</td></tr>';
                return;
            }

            bookingsTableBody.innerHTML = '';
            bookings.forEach((b, index) => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${b.service?.name ?? 'غير متوفر'}</td>
                    <td>${b.provider?.name ?? 'غير متوفر'}</td>
                    <td>${b.date ?? '-'}</td>
                    <td>${b.start_time ?? '-'}</td>
                    <td>${b.status ?? '-'}</td>
                    <td>
                        <button class="btn-link" data-id="${b.id}" data-action="details">تفاصيل</button>
                        ${['pending', 'confirmed'].includes(b.status)
                            ? `<button class="btn-link btn-danger-link" data-id="${b.id}" data-action="cancel">إلغاء</button>`
                            : ''}
                        ${b.status === 'completed'
                            ? `<button class="btn-link" data-id="${b.id}" data-action="review">تقييم</button>`
                            : ''}
                    </td>
                `;
                bookingsTableBody.appendChild(tr);
            });

            bookingsTableBody.querySelectorAll('button').forEach(btn => {
                const id = btn.dataset.id;
                const action = btn.dataset.action;
                if (action === 'details') {
                    btn.addEventListener('click', () => loadBookingDetails(id));
                }
                if (action === 'cancel') {
                    btn.addEventListener('click', () => cancelBooking(id));
                }
                if (action === 'review') {
                    btn.addEventListener('click', () => openReviewForm(id));
                }
            });

        } catch (e) {
            bookingsTableBody.innerHTML = '<tr><td colspan="7">خطأ في الاتصال بالخادم.</td></tr>';
        }
    }

    async function loadBookingDetails(id) {
        clearError();
        bookingDetails.style.display = 'block';
        bookingDetailsContent.innerHTML = 'جاري تحميل التفاصيل...';

        try {
            const res = await fetch('/api/customer/bookings/' + id, {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token,
                },
            });

            const data = await res.json();
            if (!res.ok) {
                bookingDetailsContent.innerHTML = data.message || 'فشل تحميل تفاصيل الحجز.';
                return;
            }

            const b = data.booking;
            bookingDetailsContent.innerHTML = `
                <p><strong>الخدمة:</strong> ${b.service?.name ?? '-'}</p>
                <p><strong>مقدّم الخدمة:</strong> ${b.provider?.name ?? '-'}</p>
                <p><strong>التاريخ:</strong> ${b.date ?? '-'}</p>
                <p><strong>الوقت:</strong> ${b.start_time ?? '-'} - ${b.end_time ?? '-'}</p>
                <p><strong>الحالة:</strong> ${b.status ?? '-'}</p>
                <p><strong>ملاحظاتك:</strong> ${b.notes ?? '-'}</p>
            `;
        } catch (e) {
            bookingDetailsContent.innerHTML = 'خطأ في الاتصال بالخادم.';
        }
    }

    async function cancelBooking(id) {
        if (!confirm('هل أنت متأكد من إلغاء هذا الحجز؟ قد لا يمكن التراجع.')) return;
        clearError();

        try {
            const res = await fetch(`/api/customer/bookings/${id}/cancel`, {
                method: 'PATCH',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token,
                },
            });

            const data = await res.json();
            if (!res.ok) {
                showError(data.message || 'فشل إلغاء الحجز.');
            } else {
                alert(data.message || 'تم إلغاء الحجز بنجاح.');
                loadBookings();
            }
        } catch (e) {
            showError('خطأ في الاتصال بالخادم أثناء إلغاء الحجز.');
        }
    }

    // 5) التقييمات
    const reviewFormContainer = document.getElementById('reviewFormContainer');
    const reviewBookingInfo = document.getElementById('reviewBookingInfo');
    const reviewForm = document.getElementById('reviewForm');
    const reviewCancelBtn = document.getElementById('reviewCancelBtn');
    const reviewSubmitBtn = document.getElementById('reviewSubmitBtn');
    const reviewsList = document.getElementById('reviewsList');

    function openReviewForm(bookingId) {
        document.getElementById('reviewBookingId').value = bookingId;
        reviewBookingInfo.textContent = `تقييم طلب حجز رقم #${bookingId}`;
        reviewFormContainer.style.display = 'block';
        reviewForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    reviewCancelBtn.addEventListener('click', function () {
        reviewFormContainer.style.display = 'none';
        reviewForm.reset();
    });

    reviewForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        clearError();

        const bookingId = document.getElementById('reviewBookingId').value;
        const payload = {
            rating: document.getElementById('reviewRating').value,
            comment: document.getElementById('reviewComment').value || null,
        };

        reviewSubmitBtn.disabled = true;
        reviewSubmitBtn.textContent = 'جاري إرسال التقييم...';

        try {
            const res = await fetch(`/api/customer/reviews/${bookingId}`, {
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
                showError(data.message || 'فشل إرسال التقييم.');
            } else {
                alert('تم إضافة التقييم بنجاح.');
                reviewFormContainer.style.display = 'none';
                reviewForm.reset();
                loadReviews();
            }
        } catch (e) {
            showError('خطأ في الاتصال بالخادم أثناء إرسال التقييم.');
        } finally {
            reviewSubmitBtn.disabled = false;
            reviewSubmitBtn.textContent = 'إرسال التقييم';
        }
    });

    async function loadReviews() {
        clearError();
        reviewsList.innerHTML = '<p>جاري تحميل التقييمات...</p>';

        try {
            const res = await fetch('/api/customer/reviews', {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token,
                },
            });

            const data = await res.json();
            if (!res.ok) {
                reviewsList.innerHTML = '<p>فشل تحميل التقييمات.</p>';
                return;
            }

            const reviews = data.reviews || data.data || [];

            if (!reviews.length) {
                reviewsList.innerHTML = '<p>لم تقم بإضافة أي تقييم بعد.</p>';
                return;
            }

            reviewsList.innerHTML = '';
            reviews.forEach(r => {
                const card = document.createElement('div');
                card.className = 'card';
                card.innerHTML = `
                    <h3>تقييم: ${'⭐'.repeat(r.rating ?? 0)}</h3>
                    <p class="small-muted">
                        للخدمة: ${r.booking?.service?.name ?? '-'}<br>
                        مع: ${r.booking?.provider?.name ?? '-'}
                    </p>
                    <p>${r.comment ?? 'لا يوجد تعليق نصي.'}</p>
                `;
                reviewsList.appendChild(card);
            });
        } catch (e) {
            reviewsList.innerHTML = '<p>خطأ في الاتصال بالخادم.</p>';
        }
    }

    // 6) الإشعارات
    const notificationsList = document.getElementById('notificationsList');

    async function loadNotifications() {
        clearError();
        notificationsList.innerHTML = '<li>جاري تحميل الإشعارات...</li>';

        try {
            const res = await fetch('/api/customer/notifications', {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token,
                },
            });

            const data = await res.json();
            if (!res.ok) {
                notificationsList.innerHTML = '<li>فشل تحميل الإشعارات.</li>';
                return;
            }

            const notifications = data.notifications || [];

            if (!notifications.length) {
                notificationsList.innerHTML = '<li>لا توجد إشعارات حالياً.</li>';
                return;
            }

            notificationsList.innerHTML = '';
            notifications.forEach(n => {
                const li = document.createElement('li');
                li.innerHTML = `
                    <div class="notification-title">${n.data?.message ?? 'إشعار'}</div>
                    <div class="notification-time small-muted">
                        ${n.created_at ?? ''}
                    </div>
                `;
                notificationsList.appendChild(li);
            });
        } catch (e) {
            notificationsList.innerHTML = '<li>خطأ في الاتصال بالخادم.</li>';
        }
    }

    // 7) بحث عن مقدمي الخدمة
    const providersSearchForm = document.getElementById('providersSearchForm');
    const providersList = document.getElementById('providersList');

    providersSearchForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        clearError();
        providersList.innerHTML = '<p>جاري البحث...</p>';

        const params = new URLSearchParams();
        const city = document.getElementById('providerCity').value;
        const service = document.getElementById('providerService').value;
        const keyword = document.getElementById('providerKeyword').value;

        if (city) params.append('city', city);
        if (service) params.append('service', service);
        if (keyword) params.append('q', keyword);

        try {
            const res = await fetch('/api/customer/providers/search?' + params.toString(), {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token,
                },
            });

            const data = await res.json();
            if (!res.ok) {
                providersList.innerHTML = '<p>فشل البحث عن مقدمي الخدمة.</p>';
                return;
            }

            const providers = data.providers || data.data || [];

            if (!providers.length) {
                providersList.innerHTML = '<p>لا يوجد مقدمي خدمة مطابقين للبحث.</p>';
                return;
            }

            providersList.innerHTML = '';
            providers.forEach(p => {
                const card = document.createElement('div');
                card.className = 'card';
                card.innerHTML = `
                    <h3>${p.name ?? 'مقدّم خدمة'}</h3>
                    <p class="small-muted">
                        المدينة: ${p.location_city ?? '-'}<br>
                        المنطقة: ${p.location_area ?? '-'}
                    </p>
                    <p>خبرة: ${p.experience_years ?? '-'} سنوات</p>
                    <p>متوسط تقييم: ${p.avg_rating ?? 'غير متوفر'}</p>
                `;
                providersList.appendChild(card);
            });
        } catch (e) {
            providersList.innerHTML = '<p>خطأ في الاتصال بالخادم.</p>';
        }
    });

    // تحميل افتراضي للخدمات أولاً
    loadMe();
    loadServices();
});
</script>
@endsection
