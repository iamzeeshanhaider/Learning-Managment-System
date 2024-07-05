<?php

use App\Enums\GeneralStatus;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('amount_paid')->default(0);
            $table->string('proof_of_payment')->nullable();
            $table->string('invoice_id')->nullable();
            $table->string('payment_mode')->nullable();
            $table->foreignIdFor(Payment::class, 'parent_id')->nullable()->constrained('payments');
            $table->foreignIdFor(User::class, 'student_id')->constrained('users');
            $table->enum('status', GeneralStatus::getInstances())->default(GeneralStatus::Enabled);
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
        Schema::dropIfExists('payments');
    }
};
