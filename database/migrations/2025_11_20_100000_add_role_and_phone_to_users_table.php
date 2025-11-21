<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Phone is optional for users
            $table->string('phone')->nullable()->after('email');

            // Role: admin or customer. Default to 'customer'
            $table->enum('role', ['admin', 'customer'])->default('customer')->after('phone')->index();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone']);
        });
    }
};
