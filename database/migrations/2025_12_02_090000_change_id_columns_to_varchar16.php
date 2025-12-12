<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Target: convert bigint id/foreign keys to string(16) without creating new columns
        // Specifically: bundlings.id, orders.bundling_id, sessions.user_id

        // Drop FK that references bundlings.id so we can alter types safely
        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'bundling_id')) {
            try {
                Schema::table('orders', function (Blueprint $t) {
                    $t->dropForeign(['bundling_id']);
                });
            } catch (\Throwable $e) {
                // ignore if FK not present
            }
        }

        // Change child FK column first
        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'bundling_id')) {
            try {
                Schema::table('orders', function (Blueprint $t) {
                    $t->string('bundling_id', 16)->change();
                });
            } catch (\Throwable $e) {
                DB::statement("ALTER TABLE `orders` MODIFY `bundling_id` VARCHAR(16) NOT NULL");
            }
        }

        // Change parent PK column (remove auto increment implicitly by changing type)
        if (Schema::hasTable('bundlings') && Schema::hasColumn('bundlings', 'id')) {
            try {
                Schema::table('bundlings', function (Blueprint $t) {
                    $t->string('id', 16)->change();
                });
            } catch (\Throwable $e) {
                DB::statement("ALTER TABLE `bundlings` MODIFY `id` VARCHAR(16) NOT NULL");
            }
        }

        // Recreate FK
        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'bundling_id')) {
            try {
                Schema::table('orders', function (Blueprint $t) {
                    $t->foreign('bundling_id')->references('id')->on('bundlings')->cascadeOnDelete();
                });
            } catch (\Throwable $e) {
                // ignore if cannot recreate due to existing constraints
            }
        }

        // Change sessions.user_id to string(16) (nullable), no FK by default
        if (Schema::hasTable('sessions') && Schema::hasColumn('sessions', 'user_id')) {
            try {
                Schema::table('sessions', function (Blueprint $t) {
                    $t->string('user_id', 16)->nullable()->change();
                });
            } catch (\Throwable $e) {
                DB::statement("ALTER TABLE `sessions` MODIFY `user_id` VARCHAR(16) NULL");
            }
        }
    }

    public function down(): void
    {
        // Rollback: revert types back to bigint where applicable
        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'bundling_id')) {
            try {
                Schema::table('orders', function (Blueprint $t) {
                    $t->dropForeign(['bundling_id']);
                });
            } catch (\Throwable $e) {}
        }

        if (Schema::hasTable('bundlings') && Schema::hasColumn('bundlings', 'id')) {
            try {
                Schema::table('bundlings', function (Blueprint $t) {
                    $t->bigIncrements('id')->change();
                });
            } catch (\Throwable $e) {
                // Fallback: make it BIGINT (not auto inc) to avoid errors
                try { DB::statement("ALTER TABLE `bundlings` MODIFY `id` BIGINT NOT NULL"); } catch (\Throwable $e2) {}
            }
        }

        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'bundling_id')) {
            try {
                Schema::table('orders', function (Blueprint $t) {
                    $t->unsignedBigInteger('bundling_id')->change();
                });
            } catch (\Throwable $e) {}

            try {
                Schema::table('orders', function (Blueprint $t) {
                    $t->foreign('bundling_id')->references('id')->on('bundlings')->cascadeOnDelete();
                });
            } catch (\Throwable $e) {}
        }

        if (Schema::hasTable('sessions') && Schema::hasColumn('sessions', 'user_id')) {
            try {
                Schema::table('sessions', function (Blueprint $t) {
                    $t->unsignedBigInteger('user_id')->nullable()->change();
                });
            } catch (\Throwable $e) {}
        }
    }
};
