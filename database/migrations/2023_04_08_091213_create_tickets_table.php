<?php
use App\Models\User;
use App\Models\TicketCategory;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignIdFor(User::class, 'user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(User::class, 'instructor_id')->nullable()->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(TicketCategory::class, 'category_id');
            $table->string('slug')->unique();
            $table->string('priority')->nullable();
            $table->text('message');
            $table->enum('status', ['open', 'closed', 'resolved'])->default('open');

            // Removed ticket_id, title
            // changed instructor_id and priority to nullable
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
        Schema::dropIfExists('tickets');
    }
}
