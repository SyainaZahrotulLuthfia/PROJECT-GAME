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
        Schema::create('gameplays', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('character_id');
            $table->unsignedBigInteger('level_id');
            $table->bigInteger('score');
            $table->timestamps();

            // relasi pada tabel user
            $table->foreign('user_id')->references('id')->on('users');

            // relasi pada tabel character
            $table->foreign('character_id')->references('id')->on('characters');

            // relasi pada tabel level
            $table->foreign('level_id')->references('id')->on('levels');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gameplays');
    }
};
