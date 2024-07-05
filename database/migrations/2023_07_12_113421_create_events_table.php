<?php

use App\Enums\EventGroup;
use App\Enums\GeneralStatus;
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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamp('date');
            $table->string('slug')->unique();
            $table->string('banner')->nullable();
            $table->longText('content')->nullable();
            $table->boolean('notify_group')->default(false);
            $table->foreignIdFor(User::class, 'created_by')->constrained('users');
            $table->enum('group', [EventGroup::getInstances()])->default(EventGroup::AllUsers);
            $table->enum('status', [GeneralStatus::Enabled(), GeneralStatus::Disabled()])->default(GeneralStatus::Enabled);
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
        Schema::dropIfExists('events');
    }
};
