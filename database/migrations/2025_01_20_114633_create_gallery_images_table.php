<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('gallery_images', function (Blueprint $table) {
            $table->id();
            
            
            $table->string('title_az');
            $table->string('title_en');
            $table->string('title_ru');
            
            
            $table->string('slug_az')->unique();
            $table->string('slug_en')->unique();
            $table->string('slug_ru')->unique();
            
            
            $table->text('description_az');
            $table->text('description_en');
            $table->text('description_ru');
            
            
            $table->string('main_image');
            
            
            $table->string('main_image_alt_az');
            $table->string('main_image_alt_en');
            $table->string('main_image_alt_ru');
            
            
            $table->string('bottom_image');
            
            
            $table->string('bottom_image_alt_az');
            $table->string('bottom_image_alt_en');
            $table->string('bottom_image_alt_ru');
            
          
            $table->json('multiple_images')->nullable();
            
            
            $table->string('meta_title_az')->nullable();
            $table->string('meta_title_en')->nullable();
            $table->string('meta_title_ru')->nullable();
            
            $table->text('meta_description_az')->nullable();
            $table->text('meta_description_en')->nullable();
            $table->text('meta_description_ru')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gallery_images');
    }
};