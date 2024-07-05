<?php

use App\Models\LessonFolder;
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
        if(Schema::hasTable('lesson_resources')) return;
        Schema::table('lesson_resources', function (Blueprint $table) {
            $table->foreignIdFor(LessonFolder::class, 'folder_id')->nullable()->constrained('lesson_folders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lesson_resources', function (Blueprint $table) {
            //
        });
    }
};
