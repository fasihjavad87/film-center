<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trailers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trailerable_id');
            $table->string('trailerable_type'); // Movie یا Series
            $table->string('title', 255)->default('Official Trailer');
            $table->string('video_url', 500)->nullable(); // لینک تیزر
            $table->string('video_file')->nullable(); // فایل آپلودی
            $table->unsignedSmallInteger('duration')->nullable();
            $table->unsignedTinyInteger('order')->default(1);
            $table->timestamps();

            $table->index(['trailerable_id', 'trailerable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trailers');
    }
};
