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
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('season_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->unsignedSmallInteger('episode_number');
            $table->string('episode_url', 500)->nullable();
            $table->string('episode_file')->nullable();
            $table->unsignedSmallInteger('runtime')->nullable();
            $table->timestamps();

            $table->unique(['season_id', 'episode_number'], 'season_episode_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('episodes');
    }
};
