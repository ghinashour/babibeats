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

                // Polymorphic fields: favoritable_id + favoritable_type
            $table->morphs('favoritable'); 
            // This creates: favoritable_id (BIGINT) & favoritable_type (string)

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
