<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('bundling_id')->constrained('bundlings')->onDelete('cascade');
            $table->date('book_date');
            $table->time('book_time');
            $table->enum('location', ['indoor', 'outdoor'])->default('indoor');
            $table->string('note')->nullable();
            $table->string('nama');
            $table->string('no_wa');
            $table->enum('order_status', ['unpaid', 'paid', 'pending', 'failed'])->default('unpaid');
            $table->double('total_price');
            $table->integer('sum_order')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
