@extends('layouts.public')

@section('title', 'بروفايل مزوّد الخدمة')

@section('content')
<div class="dashboard">
    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-title" id="providerNameTitle">مزوّد خدمة</h1>
            <p class="dashboard-subtitle" id="providerSubtitle">
                ...
            </p>
        </div>
        <div class="dashboard-badge" id="providerStatusBadge">...</div>
    </div>

    <div id="providerAlert" class="auth-alert auth-alert-error" style="display:none;"></div>

    {{-- معلومات أساسية --}}
    <section class="tab-section active">
        <div class="section-header">
            <h2>معلومات المزود</h2>
        </div>

        <div class="booking-details" id="providerInfoBox">
            جار تحميل البيانات...
        </div>
    </section>

    {{-- خدمات المزود --}}
    <section class="tab-section" style="margin-top:16px;">
        <div class="section-header">
            <h2>الخدمات التي يقدمها</h2>
        </div>
        <div id="providerServicesBox" class="cards-grid">
            جار تحميل الخدمات...
        </div>
    </section>

    {{-- تقييمات المزود --}}
    <section class="tab-section" style="margin-top:16px;">
        <div class="section-header">
            <h2>تقييمات العملاء</h2>
        </div>
        <div id="providerReviewsBox" class="cards-grid">
            جار تحميل التقييمات...
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const alertBox           = document.getElementById('providerAlert');
    const providerNameTitle  = document.getElementById('providerNameTitle');
    const providerSubtitle   = document.getElementById('providerSubtitle');
    const providerStatusBadge= document.getElementById('providerStatusBadge');
    const providerInfoBox    = document.getElementById('providerInfoBox');
    const providerServicesBox= document.getElementById('providerServicesBox');
    const providerReviewsBox = document.getElementById('providerReviewsBox');

    function showError(msg) {
        alertBox.style.display = 'block';
        alertBox.innerHTML = msg;
    }

    function clearError() {
        alertBox.style.display = 'none';
        alertBox.innerHTML = '';
    }

    const pathParts = window.location.pathname.split('/');
    const providerId = pathParts[pathParts.length - 1];

    if (!providerId) {
        showError('معرّف المزود غير موجود في الرابط.');
        return;
    }

    async function loadProviderProfile() {
        clearError();
        providerInfoBox.innerHTML = 'جار تحميل البيانات...';
        providerServicesBox.innerHTML = 'جار تحميل الخدمات...';
        providerReviewsBox.innerHTML = 'جار تحميل التقييمات...';

        try {
            const res = await fetch('/api/providers/' + providerId, {
                headers: { 'Accept': 'application/json' }
            });

            const data = await res.json();

            if (!res.ok) {
                providerInfoBox.innerHTML = 'فشل تحميل بيانات المزود.';
                showError(data.message || 'حدث خطأ أثناء جلب بيانات المزود.');
                return;
            }

            const p = data.provider || {};

            providerNameTitle.textContent = p.name ?? 'مزوّد خدمة';
            providerSubtitle.textContent  = `تقييم متوسط: ${p.average_rating ?? 0} / 5 - عدد الحجوزات المنفذة: ${p.total_bookings ?? 0}`;

            providerStatusBadge.textContent = p.is_available ? 'متاح حالياً' : 'غير متاح حالياً';
            providerStatusBadge.style.background = p.is_available ? '#10b981' : '#6b7280';

            providerInfoBox.innerHTML = `
                <p><strong>الاسم:</strong> ${p.name ?? '-'}</p>
                <p><strong>البريد:</strong> ${p.email ?? '-'}</p>
                <p><strong>الجوال:</strong> ${p.phone ?? '-'}</p>
                <p><strong>المدينة:</strong> ${p.location_city ?? '-'}</p>
                <p><strong>المنطقة:</strong> ${p.location_area ?? '-'}</p>
                <p><strong>سنوات الخبرة:</strong> ${p.years_of_experience ?? '-'} سنة</p>
                <p><strong>السعر الأساسي:</strong> ${p.base_price ?? '-'} ريال</p>
                <p><strong>نبذة تعريفية:</strong> ${p.bio ?? 'لا توجد نبذة مضافة.'}</p>
                <p><strong>المناطق المغطاة:</strong> ${
                    Array.isArray(p.covered_areas) && p.covered_areas.length
                        ? p.covered_areas.join('، ')
                        : 'لا توجد مناطق مضافة'
                }</p>
            `;

            // الخدمات
            const services = p.services || [];
            if (!services.length) {
                providerServicesBox.innerHTML = '<p>لا توجد خدمات مضافة لهذا المزود بعد.</p>';
            } else {
                providerServicesBox.innerHTML = '';
                services.forEach(s => {
                    const card = document.createElement('div');
                    card.className = 'card';
                    card.innerHTML = `
                        <h3>${s.name ?? 'خدمة'}</h3>
                        <p class="small-muted">
                            التصنيف: ${s.category?.name ?? '-'}
                        </p>
                        <p class="price-range">
                            السعر التقريبي: ${s.price_min ?? '-'} إلى ${s.price_max ?? '-'} ريال
                        </p>
                        <p>${s.description ?? ''}</p>
                        <a href="/service/${s.id}" class="btn-primary-small">
                            عرض هذه الخدمة
                        </a>
                    `;
                    providerServicesBox.appendChild(card);
                });
            }

            // التقييمات
            const reviews = p.reviews || [];
            if (!reviews.length) {
                providerReviewsBox.innerHTML = '<p>لا توجد تقييمات لهذا المزود حتى الآن.</p>';
            } else {
                providerReviewsBox.innerHTML = '';
                reviews.forEach(r => {
                    const card = document.createElement('div');
                    card.className = 'card';
                    const customer = r.customer || {};

                    card.innerHTML = `
                        <h3>${'⭐'.repeat(r.rating ?? 0)} (${r.rating ?? '-'}/5)</h3>
                        <p class="small-muted">
                            بواسطة: ${customer.name ?? 'زبون'}<br>
                            للخدمة: ${r.service?.name ?? '-'}
                        </p>
                        <p>${r.comment ?? 'لا يوجد تعليق نصي.'}</p>
                        <p class="small-muted">${r.created_at ?? ''}</p>
                    `;
                    providerReviewsBox.appendChild(card);
                });
            }

        } catch (e) {
            providerInfoBox.innerHTML = 'خطأ في الاتصال بالخادم.';
            showError('تعذر الاتصال بالخادم، تأكدي أن Laravel يعمل.');
        }
    }

    loadProviderProfile();
});
</script>
@endsection
