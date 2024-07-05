<?php

use App\Enums\GeneralStatus;
use App\Models\Batch;
use App\Models\Course;
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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->integer('obtainable_points')->default(0);
            $table->integer('attempts')->default(1);
            $table->float('duration')->default(30); // minutes
            $table->foreignIdFor(Course::class)->constrained();
            $table->foreignIdFor(Batch::class)->constrained();
            $table->foreignIdFor(User::class, 'created_by')->constrained('users');
            $table->enum('status', [GeneralStatus::Enabled(), GeneralStatus::Disabled()])->default(GeneralStatus::Enabled); // published and unpublished
            $table->boolean('is_average')->default(0);
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
        Schema::dropIfExists('quizzes');
    }
};
