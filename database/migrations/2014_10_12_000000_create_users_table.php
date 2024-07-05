<?php

use App\Enums\Ethnicity;
use App\Enums\Gender;
use App\Enums\GeneralStatus;
use App\Enums\UKStatus;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('lname')->nullable();
            $table->string('username')->nullable()->unique();
            $table->string('code')->nullable()->unique();

            $table->enum('gender', Gender::getInstances())->nullable();
            $table->date('dob')->nullable();

            $table->foreignId('country_id')->unsigned()->nullable();
            $table->string('city')->nullable();
            $table->longText('address')->nullable();

            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->timestamp('email_verified_at')->nullable();

            $table->string('password')->nullable();
            $table->string('designation')->nullable();
            $table->string('media_token')->unique()->nullable();
            $table->string('slug')->unique();
            $table->enum('ethnicity', Ethnicity::getInstances())->nullable();

            $table->enum('status', GeneralStatus::getInstances())->default(GeneralStatus::Enabled);
            $table->enum('uk_status', UKStatus::getInstances())->nullable();
            $table->string('image')->nullable();
            $table->boolean('has_completed_profile')->default(false);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
