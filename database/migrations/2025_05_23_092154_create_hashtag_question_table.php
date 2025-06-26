<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hashtag_question', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hashtag_id');
            $table->unsignedBigInteger('question_id');
            $table->timestamps();
            $table->unique(['hashtag_id', 'question_id']);
            $table->foreign('hashtag_id')->references('id')->on('hashtags')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hashtag_question');
    }
};