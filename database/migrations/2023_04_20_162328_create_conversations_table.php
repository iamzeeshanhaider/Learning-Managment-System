<?php

use App\Models\{User, Chat};
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversationsTable extends Migration
{
    /** 
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Chat::class, 'chat_id')->nullable()->constrained('chats')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(User::class, 'sender_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(User::class, 'receiver_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamp('last_time_message')->nullable();
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
        Schema::dropIfExists('conversations');
    }
}
