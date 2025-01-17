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
        Schema::create('home_abouts', function (Blueprint $table) {
            $table->id();
            
            // Title fields for different languages
            $table->string('title1_az');
            $table->string('title1_en');
            $table->string('title1_ru');
            $table->string('title2_az');
            $table->string('title2_en');
            $table->string('title2_ru');

            // Special titles for different languages
            $table->string('special_title1_az');
            $table->string('special_title1_en');
            $table->string('special_title1_ru');
            $table->string('special_title2_az');
            $table->string('special_title2_en');
            $table->string('special_title2_ru');
            $table->string('special_title3_az');
            $table->string('special_title3_en');
            $table->string('special_title3_ru');

            // Images and their ALT tags for different languages
            $table->json('images'); // Store image URLs
            $table->json('images_alt_az')->nullable(); 
            $table->json('images_alt_en')->nullable(); 
            $table->json('images_alt_ru')->nullable(); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_abouts');
    }
};
