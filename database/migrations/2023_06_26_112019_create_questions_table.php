<?php

use App\Enums\GeneralStatus;
use App\Models\Quiz;
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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('question');
            $table->longText('instruction')->nullable();
            $table->foreignIdFor(Quiz::class)->constrained();
            $table->enum('status', [GeneralStatus::Enabled(), GeneralStatus::Disabled()])->default(GeneralStatus::Enabled);
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
        Schema::dropIfExists('questions');
    }
};
