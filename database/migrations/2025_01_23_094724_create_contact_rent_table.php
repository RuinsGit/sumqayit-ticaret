<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactRentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_rent', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->string('brand_name'); 
            $table->string('email'); 
            $table->string('phone_prefix'); 
            $table->string('phone_number'); 
            $table->string('warehouse'); 
            $table->string('requested_area'); 
            $table->text('message'); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_rent');
    }
}
