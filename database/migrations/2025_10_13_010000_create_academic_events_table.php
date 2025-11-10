<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Fields:
     * - id
     * - title
     * - description (nullable)
     * - start_date, end_date (date)
     * - color (string) - untuk tampilan (blue, green, red, ...)
     * - created_by (user id) - admin user yang membuat
     * - is_published (bool) - publish / draft
     * - timestamps
     */
    public function up(): void
    {
        Schema::create('academic_events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('color', 32)->default('blue');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('is_published')->default(true);
            $table->timestamps();

            $table->index('start_date');
            $table->index('end_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_events');
    }
};
