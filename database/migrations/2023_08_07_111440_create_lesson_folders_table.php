<?php

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
        if(Schema::hasTable('lesson_folders')) return;
        Schema::create('lesson_folders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(Lesson::class)->nullable()->constrained();
            $table->string('slug')->unique();
            $table->boolean('is_published')->default(1);
            $table->softDeletes();
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
        Schema::dropIfExists('lesson_folders');
    }
};
