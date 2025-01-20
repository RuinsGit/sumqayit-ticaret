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
            
            // Başlıklar (her dil için)
            $table->string('title_az');
            $table->string('title_en');
            $table->string('title_ru');
            
            // Slug
            $table->string('slug_az')->unique();
            $table->string('slug_en')->unique();
            $table->string('slug_ru')->unique();
            
            // Açıklamalar (her dil için)
            $table->text('description_az');
            $table->text('description_en');
            $table->text('description_ru');
            
            // Ana görsel
            $table->string('main_image');
            
            // Ana görsel ALT metinleri
            $table->string('main_image_alt_az');
            $table->string('main_image_alt_en');
            $table->string('main_image_alt_ru');
            
            // Alt görsel
            $table->string('bottom_image');
            
            // Alt görsel ALT metinleri
            $table->string('bottom_image_alt_az');
            $table->string('bottom_image_alt_en');
            $table->string('bottom_image_alt_ru');
            
            // Çoklu resimler ve ALT metinleri için JSON sütunu
            $table->json('multiple_images')->nullable();
            
            // Meta alanları
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