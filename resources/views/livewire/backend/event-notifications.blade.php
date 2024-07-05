<div class="dropdown for-notification">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="notification" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="ti-announcement"></i>
        <span class="count bg-danger iro_notification_badge {{ should_tilt(count($notifications)) }}">{{ count($notifications) }}</span>
    </button>
    <div class="dropdown-menu" aria-labelledby="notification" style="min-width: 300px;">
        @if ($notifications->isEmpty())
            <div class="dropdown-item media bg-flat-color-2 border-bottom">
                <span class="message media-body p-2">
                    <i class="fa fa-bell fa-2x text-primary"></i>
                    <p class="">
                        You’re all caught up! Check back later for new notifications
                    </p>
                </span>
            </div>
        @else
            @foreach ($notifications as $notification)
                <div class="dropdown-item media bg-flat-color-2 border-bottom pt-1">
                    <a class="message media-body d-block cursor-pointer {{ is_disabled($notification->event->status) }}"
                        onclick="handleGeneralModal(this)"
                        wire:click="markAsRead('{{ $notification->id }}')"
                        data-link="{{ route('events.show', $notification->event->slug) }}">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="name"><b>{{ str_limit($notification->event->title, 60) }}</b></span>
                            <div class="time justify-content-end d-flex align-items-start">
                                <small class="pr-2">{{ $notification->created_at->diffForHumans() }}</small>
                                <a href="javascript:void(0)" role="button"
                                    wire:click="markAsRead('{{ $notification->id }}')" title="Mark as Read">
                                    <i class="fa fa-check" title="Mark as Read"></i>
                                </a>
                            </div>
                        </div>
                        <p class="text-wrap">
                            {!! str_limit(html_entity_decode($notification->event->content), 42) !!}
                        </p>
                    </a>
                </div>
            @endforeach

            @if ($notifications)
                <div class="text-right mt-2">
                    <button wire:click="markAllAsRead" class="btn btn-sm btn-clear text-success">
                        <i class="fa fa-check"></i> Mark all as Read
                    </button>
                </div>
            @endif
        @endif
    </div>
</div>
