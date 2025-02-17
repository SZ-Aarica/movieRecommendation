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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('adult');
            $table->text('overview');
            $table->string('poster_path')->nullable();
            $table->string('backdrop_path')->nullable();
            $table->float('vote_average');
            $table->integer('vote_count');
            $table->date('release_date');
            $table->json('genres');
            $table->integer('runtime');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
