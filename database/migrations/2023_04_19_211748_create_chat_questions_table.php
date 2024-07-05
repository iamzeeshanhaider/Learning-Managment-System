<?php
use App\Models\ChatLayer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignIdFor(ChatLayer::class, 'chat_layer_id');
            $table->text('question');
            $table->enum('status', ['enabled', 'disabled'])->default('enabled');
            $table->string('slug')->unique();
            $table->foreignIdFor(User::class, 'created_by_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(User::class, 'updated_by_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('chat_questions');
    }
};
