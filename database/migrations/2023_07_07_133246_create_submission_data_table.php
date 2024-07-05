<?php

use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Submission;
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
        Schema::create('submission_data', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Submission::class)->constrained();
            $table->foreignIdFor(Question::class)->constrained();
            $table->foreignIdFor(QuestionOption::class, 'option_id')->nullable()->constrained('question_options');
            $table->longText('value')->nullable();
            $table->string('file')->nullable();
            $table->boolean('is_correct')->default(0);
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
        Schema::dropIfExists('submission_data');
    }
};
