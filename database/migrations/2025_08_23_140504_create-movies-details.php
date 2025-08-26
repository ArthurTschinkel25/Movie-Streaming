<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movie_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('movie_id')->unique();
            $table->integer('runtime');
            $table->decimal('popularity', 10, 2);
            $table->string('imdb_id')->nullable();
            $table->string('origin_country')->nullable();
            $table->boolean('adult')->default(false);
            $table->bigInteger('budget')->nullable();
            $table->timestamps();

            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movie_details');
    }
};
