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
        Schema::create('movie_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('movieable_id');
            $table->string('movieable_type');
            $table->string('imdb_id', 15)->nullable();
            $table->decimal('imdb_rating', 3, 1)->nullable();
            $table->integer('release_year')->nullable();
            $table->string('language', 50)->nullable();
            $table->string('age_rating', 10)->nullable();
            $table->string('poster')->nullable();
            $table->timestamps();

            $table->index(['movieable_id', 'movieable_type'], 'movieable_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_details');
    }
};
