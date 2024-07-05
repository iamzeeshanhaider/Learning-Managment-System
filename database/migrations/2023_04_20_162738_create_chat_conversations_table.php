<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\ChatQuestion;
use App\Models\ChatOption;
use App\Models\ChatLayer;
use App\Models\Chat;
use App\Enums\GeneralStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_conversations', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->foreignIdFor(Chat::class, 'chat_id');
            $table->foreignIdFor(ChatLayer::class, 'chat_layer_id');
            $table->foreignIdFor(ChatQuestion::class, 'chat_question_id');
            $table->foreignIdFor(ChatOption::class, 'chat_option_id');
            $table->enum('status', GeneralStatus::getInstances())->default(GeneralStatus::Enabled);
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
        Schema::dropIfExists('chat_conversations');
    }
};
