<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_nim', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_induk', 20)->unique();
            $table->enum('role', ['mahasiswa', 'dosen', 'admin']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_nim');
    }
};