<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bundlings', function (Blueprint $table) {
            $table->id();
            $table->string('name_bundling');
            $table->double('price_bundling');
            $table->string('description_bundling')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bundlings');
    }
};
