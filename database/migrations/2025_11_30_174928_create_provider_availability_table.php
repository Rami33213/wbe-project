<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('provider_availability', function (Blueprint $table) {
            $table->id();

            // ربط التوفر بالمزود
            $table->foreignId('provider_id')
                  ->constrained('users')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // التاريخ والوقت
            $table->date('date')->index();
            $table->time('start_time');
            $table->time('end_time');

            // خيار التكرار (مثلاً كل أسبوع)
            $table->boolean('is_recurring')->default(false);
            $table->string('recurring_rule')->nullable(); // weekly, monthly...

            $table->boolean('is_active')->default(true)->index();

            $table->timestamps();

            // منع التضارب: فهرس مركب على المزود + التاريخ + الوقت
            $table->index(['provider_id', 'date', 'start_time', 'end_time']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('provider_availability');
    }
};
