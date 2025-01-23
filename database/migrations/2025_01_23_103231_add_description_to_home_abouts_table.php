<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionToHomeAboutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('home_abouts', function (Blueprint $table) {
            $table->text('description_az')->nullable()->after('special_title3_ru');
            $table->text('description_en')->nullable()->after('description_az');
            $table->text('description_ru')->nullable()->after('description_en');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('home_abouts', function (Blueprint $table) {
            $table->dropColumn(['description_az', 'description_en', 'description_ru']);
        });
    }
}