<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('admin_actions', function (Blueprint $table) {
            $table->id();

            // الأدمن المنفذ للعملية
            $table->foreignId('admin_id')
                  ->constrained('users')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // نوع العملية
            $table->enum('action_type', [
                'suspend_provider',   // تعليق مزود
                'unsuspend_provider', // إعادة تفعيل مزود
                'delete_service',     // حذف خدمة
                'update_service',     // تعديل خدمة
                'cancel_booking',     // إلغاء حجز
                'other'               // أي إجراء آخر
            ])->index();

            // الهدف من العملية (مزود، خدمة، حجز)
            $table->unsignedBigInteger('target_id')->nullable();
            $table->string('target_type')->nullable(); // user, service, booking

            // تفاصيل إضافية
            $table->text('reason')->nullable();

            $table->timestamps();

            // فهرس مركب للتتبع السريع
            $table->index(['action_type', 'target_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_actions');
    }
};
