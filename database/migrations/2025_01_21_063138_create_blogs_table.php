<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();

            // Başlık
            $table->string('title_az');
            $table->string('title_en');
            $table->string('title_ru');

            // Resim
            $table->string('main_image');
            $table->string('main_image_alt_az')->nullable();
            $table->string('main_image_alt_en')->nullable();
            $table->string('main_image_alt_ru')->nullable();

            // Metin
            $table->text('text_az');
            $table->text('text_en');
            $table->text('text_ru');

            // Açıklama
            $table->text('description_1_az')->nullable();
            $table->text('description_1_en')->nullable();
            $table->text('description_1_ru')->nullable();

            $table->text('description_2_az')->nullable();
            $table->text('description_2_en')->nullable();
            $table->text('description_2_ru')->nullable();

            // Alt Resimler
            $table->string('bottom_images')->nullable();
            $table->string('bottom_images_alt_az')->nullable();
            $table->string('bottom_images_alt_en')->nullable();
            $table->string('bottom_images_alt_ru')->nullable();

            // Meta Bilgileri
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
        Schema::dropIfExists('blogs');
    }
}