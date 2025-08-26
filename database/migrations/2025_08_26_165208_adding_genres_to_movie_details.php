<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('movie_details', function (Blueprint $table) {
            $table->string('genres')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('movie_details', function (Blueprint $table) {
            $table->dropColumn('genres');
        });
    }
};
