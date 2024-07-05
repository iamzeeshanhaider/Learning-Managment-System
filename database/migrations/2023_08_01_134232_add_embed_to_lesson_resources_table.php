<?php

use App\Enums\LessonResourceType;
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
        Schema::table('lesson_resources', function (Blueprint $table) {
            $table->enum('type', LessonResourceType::getInstances())->nullable()->change();
            $table->longText('embed_code')->nullable()->after('type');
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
