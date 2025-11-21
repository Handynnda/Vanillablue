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

            // foreign key ke tabel users
            $table->foreignId('customer_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('bundling_id')
                ->constrained('bundlings')
                ->onDelete('cascade');

            $table->date('book_date');
            $table->time('book_time');
            $table->enum('location', ['indoor', 'outdoor'])->default('indoor');
            $table->string('note')->nullable();
            $table->enum('order_status', ['unpaid', 'paid', 'pending', 'failed'])->default('unpaid');
            $table->double('total_price');
            $table->integer('sum_order')->default(1);

            $table->string('name');
            $table->string('phone', 20);


            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
