@extends('layouts.public')

@section('title', 'تفاصيل الخدمة')

@section('content')
<div class="dashboard">
    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-title" id="serviceName">تفاصيل الخدمة</h1>
            <p class="dashboard-subtitle" id="serviceSubtitle">
                ...
            </p>
        </div>
    </div>

    <div id="serviceAlert" class="auth-alert auth-alert-error" style="display:none;"></div>

    <section class="tab-section active">
        <div class="section-header">
            <h2>معلومات الخدمة</h2>
        </div>

        <div class="booking-details" id="serviceDetailsBox">
            جار تحميل تفاصيل الخدمة...
        </div>
    </section>

    <section class="tab-section" style="margin-top:16px;">
        <div class="section-header">
            <h2>تقييمات هذه الخدمة</h2>
        </div>

        <div id="serviceReviewsBox" class="cards-grid">
            جار تحميل التقييمات...
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const alertBox = document.getElementById('serviceAlert');
    const serviceNameEl = document.getElementById('serviceName');
    const serviceSubtitleEl = document.getElementById('serviceSubtitle');
    const serviceDetailsBox = document.getElementById('serviceDetailsBox');
    const serviceReviewsBox = document.getElementById('serviceReviewsBox');

    function showError(msg) {
        alertBox.style.display = 'block';
        alertBox.innerHTML = msg;
    }

    function clearError() {
        alertBox.style.display = 'none';
        alertBox.innerHTML = '';
    }

    // جلب ID من الـ URL: /service/{id}
    const pathParts = window.location.pathname.split('/');
    const serviceId = pathParts[pathParts.length - 1];

    if (!serviceId) {
        showError('معرّف الخدمة غير موجود في الرابط.');
        return;
    }

    async function loadServiceDetails() {
        clearError();
        serviceDetailsBox.innerHTML = 'جار تحميل تفاصيل الخدمة...';

        try {
            const res = await fetch('/api/services/' + serviceId, {
                headers: { 'Accept': 'application/json' }
            });

            const data = await res.json();

            if (!res.ok) {
                serviceDetailsBox.innerHTML = 'فشل تحميل تفاصيل الخدمة.';
                showError(data.message || 'حدث خطأ أثناء جلب تفاصيل الخدمة.');
                return;
            }

            const service = data.service || {};

            const provider = service.provider || {};
            const category = service.category || {};

            serviceNameEl.textContent = service.name ?? 'خدمة بدون اسم';
            serviceSubtitleEl.textContent = category.name
                ? `التصنيف: ${category.name}`
                : 'خدمة ضمن منصة الخدمات المنزلية';

            serviceDetailsBox.innerHTML = `
                <p><strong>اسم الخدمة:</strong> ${service.name ?? '-'}</p>
                <p><strong>الوصف:</strong> ${service.description ?? 'لا يوجد وصف مضاف.'}</p>
                <p><strong>التصنيف:</strong> ${category.name ?? '-'}</p>
                <p><strong>السعر التقريبي:</strong> ${service.price_min ?? '-'} إلى ${service.price_max ?? '-'} ريال</p>
                <p><strong>مزوّد الخدمة:</strong>
                    ${provider.id
                        ? `<a href="/provider/${provider.id}">${provider.name ?? 'مزوّد خدمة'}</a>`
                        : (provider.name ?? 'غير متوفر')
                    }
                </p>
                <p><strong>المدينة:</strong> ${provider.location_city ?? '-'}</p>
                <p><strong>المنطقة:</strong> ${provider.location_area ?? '-'}</p>
            `;
        } catch (e) {
            serviceDetailsBox.innerHTML = 'خطأ في الاتصال بالخادم.';
            showError('تعذر الاتصال بالخادم، تأكدي أن Laravel يعمل.');
        }
    }

    async function loadServiceReviews() {
        serviceReviewsBox.innerHTML = 'جار تحميل التقييمات...';

        try {
            const res = await fetch('/api/reviews/service/' + serviceId, {
                headers: { 'Accept': 'application/json' }
            });

            const data = await res.json();

            if (!res.ok) {
                serviceReviewsBox.innerHTML = '<p>فشل تحميل التقييمات.</p>';
                return;
            }

            const reviews = data.reviews || [];

            if (!reviews.length) {
                serviceReviewsBox.innerHTML = '<p>لا توجد تقييمات لهذه الخدمة حتى الآن.</p>';
                return;
            }

            serviceReviewsBox.innerHTML = '';
            reviews.forEach(r => {
                const card = document.createElement('div');
                card.className = 'card';

                const customer = r.customer || {};
                const provider = r.provider || {};

                card.innerHTML = `
                    <h3>${'⭐'.repeat(r.rating ?? 0)} (${r.rating ?? '-'}/5)</h3>
                    <p class="small-muted">
                        بواسطة: ${customer.name ?? 'زبون'}<br>
                        لمزوّد الخدمة: ${provider.name ?? 'غير محدد'}
                    </p>
                    <p>${r.comment ?? 'لا يوجد تعليق نصي.'}</p>
                    <p class="small-muted">${r.created_at ?? ''}</p>
                `;

                serviceReviewsBox.appendChild(card);
            });

        } catch (e) {
            serviceReviewsBox.innerHTML = '<p>خطأ في الاتصال بالخادم.</p>';
        }
    }

    loadServiceDetails();
    loadServiceReviews();
});
</script>
@endsection
