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
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
             // The user who favorites something
              $table->foreignId('user_id')
              ->constrained()
              ->onDelete('cascade');
            $table->unsignedBigInteger('favorable_id'); // polymorphic ID
            $table->string('favorable_type'); // polymorphic Type (Track, Album, Playlist, Artist)
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
