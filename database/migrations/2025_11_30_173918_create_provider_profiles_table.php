<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('provider_profiles', function (Blueprint $table) {
            $table->id();

            // كل بروفايل مرتبط بمستخدم دور "provider"
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            $table->text('bio')->nullable();
            $table->unsignedSmallInteger('years_of_experience')->default(0);
            $table->decimal('base_price', 10, 2)->nullable();

            // المناطق المغطاة بصيغة JSON (قائمة مدن/أحياء)
            $table->json('covered_areas')->nullable();

            // تخزين متوسط التقييم ككاش للتصفّح السريع
            $table->decimal('average_rating', 3, 2)->default(0.00);

            // حالة التوفر العامة
            $table->boolean('is_available')->default(true)->index();

            $table->timestamps();

            // فهرس لمزود الخدمة يسهل الوصول لبروفايله بسرعة
            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('provider_profiles');
    }
};
