<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_badges', function (Blueprint $table) {
            // Jika tabel bernama berbeda, ganti 'user_badges'.
            if (!Schema::hasColumn('user_badges', 'achieved_at')) {
                $table->timestamp('achieved_at')->nullable()->after('badge_id')->comment('Waktu user mencapai badge');
            }
        });
    }

    public function down(): void
    {
        Schema::table('user_badges', function (Blueprint $table) {
            if (Schema::hasColumn('user_badges', 'achieved_at')) {
                $table->dropColumn('achieved_at');
            }
        });
    }
};