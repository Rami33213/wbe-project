<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');

            // معلومات اتصال وموقع
            $table->string('phone')->nullable()->index();
            $table->string('location_city')->nullable()->index();
            $table->string('location_area')->nullable()->index();

            // الدور والحالة
            $table->enum('role', ['customer', 'provider', 'admin'])->default('customer')->index();
            $table->enum('status', ['active', 'suspended'])->default('active')->index();

            // التوقيتات
            $table->rememberToken();
            $table->timestamps();
            $table->timestamp('email_verified_at')->nullable();


            // فهارس مركبة مفيدة للبحث
            $table->index(['role', 'status']);
            $table->index(['location_city', 'location_area']);
        });
        Schema::table('users', function (Blueprint $table) {
    $table->boolean('is_active')->default(true)->after('role');
});

    }

    public function down(): void
    {
        Schema::dropIfExists('users');
         Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('is_active');
    });
    }
};
