<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            // ربط التقييم بالزبون
            $table->foreignId('customer_id')
                  ->constrained('users')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // ربط التقييم بالمزود
            $table->foreignId('provider_id')
                  ->constrained('users')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // ربط التقييم بالخدمة
            $table->foreignId('service_id')
                  ->constrained('services')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // ربط التقييم بالحجز (اختياري لكن مفيد)
            $table->foreignId('booking_id')
                  ->constrained('bookings')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // عدد النجوم (1–5)
            $table->unsignedTinyInteger('rating')->comment('1 to 5 stars');

            // نص المراجعة
            $table->text('comment')->nullable();

            $table->timestamps();

            // فهارس للبحث السريع
            $table->index(['provider_id', 'service_id']);
            $table->index(['customer_id', 'booking_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
