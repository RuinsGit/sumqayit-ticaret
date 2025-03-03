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
            
            $table->string('title_az');
            $table->string('title_en');
            $table->string('title_ru');
            
            $table->string('slug_az')->unique();
            $table->string('slug_en')->unique();
            $table->string('slug_ru')->unique();
            
            $table->string('main_video')->nullable();
            $table->string('main_video_thumbnail')->nullable();
            $table->string('main_video_alt_az')->nullable();
            $table->string('main_video_alt_en')->nullable();
            $table->string('main_video_alt_ru')->nullable();
            
            $table->string('bottom_video')->nullable();
            $table->string('bottom_video_thumbnail')->nullable();
            $table->string('bottom_video_alt_az')->nullable();
            $table->string('bottom_video_alt_en')->nullable();
            $table->string('bottom_video_alt_ru')->nullable();
            
            $table->json('multiple_videos')->nullable();
            
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
