<?php

use App\Models\TicketComment;
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
        Schema::create('comment_attachements', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->foreignIdFor(TicketComment::class, 'comment_id')->nullable()->constrained('ticket_comments');
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
        Schema::dropIfExists('comment_attachements');
    }
};
