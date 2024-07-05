<?php

use App\Models\User;
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
        Schema::create('student_infos', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->unique();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();

            //Kin Information
            $table->string('nok_name')->nullable();
            $table->string('nok_relation')->nullable();
            $table->string('nok_phone')->nullable();
            $table->string('nok_email')->nullable();

            //About Career
            $table->string('qualification')->nullable();
            $table->string('employment_status')->nullable();
            $table->string('years_of_experience')->nullable();

            //About Training
            $table->string('how_did_you_hear_about_us')->nullable();

            $table->string('professional_registration_body')->nullable();
            $table->string('att_level')->nullable();
            $table->boolean('signed_doc')->default(false);

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
        Schema::dropIfExists('student_infos');
    }
};
