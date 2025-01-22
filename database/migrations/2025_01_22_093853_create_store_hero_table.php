<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('store_hero', function (Blueprint $table) {
        $table->id();
        $table->string('image');
        $table->string('image_alt_az');
        $table->string('image_alt_en');
        $table->string('image_alt_ru');
        $table->string('title_az');
        $table->string('title_en');
        $table->string('title_ru');
        $table->text('description_az');
        $table->text('description_en');
        $table->text('description_ru');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_hero');
    }
};
