<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('booking_logs', function (Blueprint $table) {
            $table->id();

            // ربط السجل بالحجز
            $table->foreignId('booking_id')
                  ->constrained('bookings')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // من غيّر الحالة (مزود، زبون، أو أدمن)
            $table->foreignId('changed_by')
                  ->constrained('users')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // الحالة القديمة والجديدة
            $table->enum('old_status', [
                'pending','accepted','rejected','cancelled','completed'
            ])->nullable();

            $table->enum('new_status', [
                'pending','accepted','rejected','cancelled','completed'
            ]);

            // سبب التغيير أو ملاحظات
            $table->text('reason')->nullable();

            $table->timestamps();

            // فهرس مركب للتتبع السريع
            $table->index(['booking_id', 'new_status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_logs');
    }
};
