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
            $table->json('description_bundling')->nullable();
            $table->enum('category', [
                'Baby & Kids','Birthday','Maternity','Prewed','Graduation','Family',
                'Group','Couple','Personal','Pas Foto','Print & Frame'
            ])->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bundlings');
    }
};
