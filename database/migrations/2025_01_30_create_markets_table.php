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
        Schema::create('markets', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('image_alt_az')->nullable();
            $table->string('image_alt_en')->nullable();
            $table->string('image_alt_ru')->nullable();
            $table->string('name_az');
            $table->string('name_en')->nullable();
            $table->string('name_ru')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        Schema::table('stores', function (Blueprint $table) {
            $table->foreignId('market_id')->nullable()->after('store_type_id')->constrained('markets')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropForeign(['market_id']);
            $table->dropColumn('market_id');
        });

        Schema::dropIfExists('markets');
    }
}; 