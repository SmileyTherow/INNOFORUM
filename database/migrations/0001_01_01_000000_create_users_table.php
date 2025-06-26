<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('username', 50)->unique();
                $table->enum('role', ['mahasiswa', 'dosen', 'admin']);
                $table->string('name', 100);
                $table->string('email', 255)->unique();
                $table->string('password', 255);
                $table->string('prodi', 100)->nullable();
                $table->string('avatar', 255)->nullable();
                $table->string('remember_token', 100)->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};