<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            // ربط الحجز بالزبون
            $table->foreignId('customer_id')
                  ->constrained('users')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // ربط الحجز بالمزود
            $table->foreignId('provider_id')
                  ->constrained('users')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // ربط الحجز بالخدمة
            $table->foreignId('service_id')
                  ->constrained('services')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // تفاصيل الموعد
            $table->date('date')->index();
            $table->time('start_time');
            $table->time('end_time');

            // تفاصيل إضافية
            $table->string('address_text')->nullable();
            $table->string('city')->nullable();
            $table->string('area')->nullable();
            $table->decimal('approx_price', 10, 2)->nullable();

            // حالة الحجز
            $table->enum('status', ['pending','confirmed','cancelled'])->default('pending');


            // سبب الرفض (اختياري)
            $table->text('reject_reason')->nullable();

            // ملاحظات إضافية
            $table->text('notes')->nullable();

            // مهلة الإلغاء (بالساعات قبل الموعد)
            $table->unsignedSmallInteger('cancel_deadline_hours')->default(2);

            $table->timestamps();

            // فهارس مركبة
            $table->index(['provider_id', 'date', 'start_time', 'end_time']);
            $table->index(['customer_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
