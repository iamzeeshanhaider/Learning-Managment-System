<?php

namespace App\Jobs;

use App\Models\Event;
use App\Models\EventNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessEventNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $event;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {

        Log::info('Started Event Notification Cron Job');
        try {
            $event = $this->event;
            $users = $this->event->getUsersForNotification();

            if ($users->count() > 0) {
                // Notify users after event is cretaed
                $users->chunk(500, function ($usersChunk) use ($event) {
                    foreach ($usersChunk as $user) {
                        $eventNotification = EventNotification::firstOrCreate(['event_id' => $event->id, 'user_id' => $user->id]);

                        if ($event->notify_group) {
                            $eventNotification->sendNotification();
                        }
                    }
                });
            }
            Log::info('Completed Event Notification Cron Job: ' . $event->title);
        } catch (\Exception $e) {
            Log::info('Error while processing Started Event Notification Cron Job: ' . $e->getMessage());
        }
    }
}
