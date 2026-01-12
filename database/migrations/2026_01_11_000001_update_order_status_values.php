<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update existing data: unpaid -> confirmed, paid -> completed
        DB::table('orders')->where('order_status', 'unpaid')->update(['order_status' => 'confirmed']);
        DB::table('orders')->where('order_status', 'paid')->update(['order_status' => 'completed']);

        // Alter table to update enum values
        DB::statement("ALTER TABLE orders MODIFY COLUMN order_status ENUM('confirmed', 'completed', 'pending', 'failed') DEFAULT 'confirmed'");
    }

    public function down(): void
    {
        // Rollback: confirmed -> unpaid, completed -> paid
        DB::table('orders')->where('order_status', 'confirmed')->update(['order_status' => 'unpaid']);
        DB::table('orders')->where('order_status', 'completed')->update(['order_status' => 'paid']);

        // Restore original enum
        DB::statement("ALTER TABLE orders MODIFY COLUMN order_status ENUM('unpaid', 'paid', 'pending', 'failed') DEFAULT 'unpaid'");
    }
};
