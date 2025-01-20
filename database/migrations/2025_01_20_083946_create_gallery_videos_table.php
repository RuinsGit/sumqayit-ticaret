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
        Schema::create('gallery_videos', function (Blueprint $table) {
            $table->id();
            
            // Titles
            $table->string('title_az');
            $table->string('title_en');
            $table->string('title_ru');
            
            // Slugs
            $table->string('slug_az')->unique();
            $table->string('slug_en')->unique();
            $table->string('slug_ru')->unique();
            
            // Main Video
            $table->string('main_video');
            $table->string('main_video_thumbnail');
            $table->string('main_video_alt_az');
            $table->string('main_video_alt_en');
            $table->string('main_video_alt_ru');
            
            // Bottom Video
            $table->string('bottom_video');
            $table->string('bottom_video_thumbnail');
            $table->string('bottom_video_alt_az');
            $table->string('bottom_video_alt_en');
            $table->string('bottom_video_alt_ru');
            
            // Multiple Videos - JSON array
            $table->json('multiple_videos')->nullable();
            
            // Meta Fields
            $table->string('meta_title_az')->nullable();
            $table->string('meta_title_en')->nullable();
            $table->string('meta_title_ru')->nullable();
            $table->text('meta_description_az')->nullable();
            $table->text('meta_description_en')->nullable();
            $table->text('meta_description_ru')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_videos');
    }
};
