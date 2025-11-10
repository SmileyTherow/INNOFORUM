<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordResetCodesTable extends Migration
{
    public function up()
    {
        Schema::create('password_reset_codes', function (Blueprint $table) {
            $table->id();
            $table->string('email')->index();
            $table->string('token_hash'); // hashed 6-digit code
            $table->timestamp('expires_at')->nullable();
            $table->unsignedTinyInteger('attempts')->default(0);
            $table->timestamp('locked_until')->nullable();
            $table->timestamps();

            $table->index(['email', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('password_reset_codes');
    }
}
