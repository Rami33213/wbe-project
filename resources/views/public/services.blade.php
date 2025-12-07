@extends('layouts.public')

@section('title', 'استعراض الخدمات')

@section('content')
<div class="dashboard">
    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-title">الخدمات المنزلية المتاحة</h1>
            <p class="dashboard-subtitle">
                استعرض خدمات التنظيف، السباكة، الكهرباء، الدهان وغيرها، واختر ما يناسبك.
            </p>
        </div>
    </div>

    <div id="publicServicesAlert" class="auth-alert auth-alert-error" style="display:none;"></div>

    <section class="tab-section active">
        <div class="section-header">
            <h2>بحث وفلترة</h2>
            <p>يمكنك تضييق النتائج بحسب المدينة، التصنيف، والسعر التقريبي.</p>
        </div>

        <form id="publicServicesFilterForm" class="filter-form">
            <div class="form-row-inline">
                <div>
                    <label>المدينة</label>
                    <input type="text" id="publicFilterCity" placeholder="مثال: الرياض">
                </div>
                <div>
                    <label>ID التصنيف</label>
                    <input type="number" id="publicFilterCategoryId" min="1" placeholder="مثال: 1">
                </div>
                <div>
                    <label>السعر الأدنى</label>
                    <input type="number" id="publicFilterPriceMin" min="0">
                </div>
                <div>
                    <label>السعر الأعلى</label>
                    <input type="number" id="publicFilterPriceMax" min="0">
                </div>
            </div>
            <button type="submit" class="btn-primary-small">تطبيق الفلتر</button>
        </form>

        <div id="publicServicesList" class="cards-grid">
            {{-- يتم ملؤها بالـ JS --}}
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const alertBox = document.getElementById('publicServicesAlert');
    const servicesList = document.getElementById('publicServicesList');
    const filterForm = document.getElementById('publicServicesFilterForm');

    function showError(msg) {
        alertBox.style.display = 'block';
        alertBox.innerHTML = msg;
    }

    function clearError() {
        alertBox.style.display = 'none';
        alertBox.innerHTML = '';
    }

    async function loadServices() {
        clearError();
        servicesList.innerHTML = '<p>جاري تحميل الخدمات...</p>';

        const params = new URLSearchParams();
        const city = document.getElementById('publicFilterCity').value;
        const catId = document.getElementById('publicFilterCategoryId').value;
        const priceMin = document.getElementById('publicFilterPriceMin').value;
        const priceMax = document.getElementById('publicFilterPriceMax').value;

        if (city) params.append('city', city);
        if (catId) params.append('category_id', catId);
        if (priceMin) params.append('price_min', priceMin);
        if (priceMax) params.append('price_max', priceMax);

        try {
            // نفترض أن الراوت في api.php هو: Route::get('/services', ...)
            const res = await fetch('/api/services?' + params.toString(), {
                headers: { 'Accept': 'application/json' }
            });

            const data = await res.json();

            if (!res.ok) {
                servicesList.innerHTML = '<p>فشل تحميل الخدمات.</p>';
                showError(data.message || 'حدث خطأ أثناء جلب الخدمات.');
                return;
            }

            const services = data.services?.data || data.services || [];

            if (!services.length) {
                servicesList.innerHTML = '<p>لا توجد خدمات مطابقة للبحث.</p>';
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
                        المزوّد: ${provider.name ?? 'غير متوفر'}<br>
                        المدينة: ${provider.location_city ?? 'غير محددة'}
                    </p>
                    <p class="price-range">
                        السعر التقريبي:
                        ${service.price_min ?? '-'} إلى ${service.price_max ?? '-'} ريال
                    </p>
                    <div style="margin-top:8px; display:flex; gap:6px; flex-wrap:wrap;">
                        <a href="/service/${service.id}" class="btn-primary-small">
                            عرض تفاصيل الخدمة
                        </a>
                        ${service.provider_id ? `
                        <a href="/provider/${service.provider_id}" class="btn-primary-small" style="background:#10b981;">
                            صفحة مزوّد الخدمة
                        </a>` : ''}
                    </div>
                `;

                servicesList.appendChild(card);
            });

        } catch (e) {
            servicesList.innerHTML = '<p>خطأ في الاتصال بالخادم.</p>';
            showError('تعذر الاتصال بالخادم، تأكدي أن Laravel يعمل.');
        }
    }

    filterForm.addEventListener('submit', function (e) {
        e.preventDefault();
        loadServices();
    });

    // تحميل أولي
    loadServices();
});
</script>
@endsection
