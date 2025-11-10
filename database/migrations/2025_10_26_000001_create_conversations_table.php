<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversationsTable extends Migration
{
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_group')->default(false);
            // for 1-on-1 convenience store ordered pair
            $table->unsignedBigInteger('user_a_id')->nullable();
            $table->unsignedBigInteger('user_b_id')->nullable();
            $table->timestamp('last_message_at')->nullable();
            $table->timestamps();

            $table->unique(['user_a_id', 'user_b_id']);
            $table->index('last_message_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('conversations');
    }
}
