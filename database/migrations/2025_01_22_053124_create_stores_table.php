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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            
            // Store type relationship
            $table->foreignId('store_type_id')->constrained('store_types')->onDelete('cascade');
            
            // Main image and its alt texts
            $table->string('image')->nullable();
            $table->string('image_alt_az')->nullable();
            $table->string('image_alt_en')->nullable();
            $table->string('image_alt_ru')->nullable();
            
            // Bottom image and its alt texts
            $table->string('bottom_image')->nullable();
            $table->string('bottom_image_alt_az')->nullable();
            $table->string('bottom_image_alt_en')->nullable();
            $table->string('bottom_image_alt_ru')->nullable();
            
            // Description in multiple languages
            $table->text('description_az');
            $table->text('description_en')->nullable();
            $table->text('description_ru')->nullable();
            
            // Working hours
            $table->string('working_hours_az');
            $table->string('working_hours_en')->nullable();
            $table->string('working_hours_ru')->nullable();
            $table->string('working_hours_image')->nullable();
            
            // Contact number
            $table->string('number');
            $table->string('number_image')->nullable();
            
            // Email
            $table->string('email');
            $table->string('email_image')->nullable();
            
            // Link
            $table->string('link')->nullable();
            $table->string('link_image')->nullable();
            
            // Common fields
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
