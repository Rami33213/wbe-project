<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();

            // ربط الخدمة بمزود خدمة
            $table->foreignId('provider_id')
                  ->constrained('users')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // ربط الخدمة بالتصنيف
            $table->foreignId('category_id')
                  ->constrained('service_categories')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            $table->string('name'); // عنوان الخدمة (تنظيف منزل صغير)
            $table->text('description')->nullable();
            $table->decimal('price_min', 10, 2)->nullable();
            $table->decimal('price_max', 10, 2)->nullable();
            $table->unsignedSmallInteger('duration_minutes')->nullable(); // مدة الخدمة المتوقعة
            $table->boolean('is_active')->default(true)->index();

            $table->timestamps();

            // فهارس للبحث السريع
            $table->index(['provider_id', 'category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
