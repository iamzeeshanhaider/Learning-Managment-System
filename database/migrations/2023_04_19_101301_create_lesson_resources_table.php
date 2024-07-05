<?php

use App\Enums\GeneralStatus;
use App\Enums\LessonResourceType;
use App\Models\Lesson;
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
        Schema::create('lesson_resources', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('file')->nullable();
            $table->longText('url')->nullable();
            $table->string('slug')->unique();
            $table->enum('type', LessonResourceType::getInstances())->nullable();
            $table->enum('status', GeneralStatus::getInstances())->default(GeneralStatus::Enabled);
            $table->foreignIdFor(Lesson::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('lesson_resources');
    }
};
