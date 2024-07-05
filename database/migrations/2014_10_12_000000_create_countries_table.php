<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191)->unique();
            $table->string('iso3', 191)->nullable()->index();
            $table->string('iso2', 191)->nullable()->index();
            $table->string('phonecode', 191)->nullable()->index();
            $table->string('capital', 191)->nullable()->index();
            $table->string('currency', 191)->nullable()->index();
            $table->string('native', 191)->nullable()->index();
            $table->string('region', 191)->nullable()->index();
            $table->string('subregion', 191)->nullable()->index();
            $table->string('emoji')->nullable()->index();
            $table->string('emojiu', 191)->nullable()->index();
            $table->boolean('flag')->default(false)->index();
            $table->string('wikiDataId', 191)->nullable()->comment('Rapid API GeoDB Cities')->index();
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
        Schema::dropIfExists('countries');
    }
};
