<?php

use App\Models\Batch;
use App\Models\Course;
use App\Models\Payment;
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
        Schema::create('batch_users', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'student_id')->constrained('users');
            $table->foreignIdFor(Course::class)->constrained();
            $table->foreignIdFor(Batch::class)->constrained();
            $table->foreignIdFor(Payment::class)->constrained()->nullable();
            $table->json('completed_resources')->nullable();
            $table->json('submitted_quiz')->nullable();
            $table->integer('fee')->nullable()->default(0);
            $table->integer('fee_after_discount')->nullable()->default(0);
            $table->string('discount')->nullable()->default(0);
            $table->date('next_payment_due_date')->nullable();
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
        Schema::dropIfExists('batch_users');
    }
};
