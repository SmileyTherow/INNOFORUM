<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('answer_points')->default(0)->after('points');
            $table->unsignedBigInteger('like_points')->default(0)->after('answer_points');
            $table->index('answer_points');
            $table->index('like_points');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['answer_points']);
            $table->dropIndex(['like_points']);
            $table->dropColumn(['answer_points', 'like_points']);
        });
    }
};
