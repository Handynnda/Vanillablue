<?php
// NOTE: Jika saat menjalankan `php artisan ...` muncul error:
//   Failed to open stream: No such file or directory .../vendor/autoload.php
// maka jalankan `composer install` di folder proyek (d:\KULIAH\SEMESTER 7\KP\Project\user\Vanillablue)
// untuk membuat folder vendor dan file autoload.php.
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'address']);
        });
    }
};
