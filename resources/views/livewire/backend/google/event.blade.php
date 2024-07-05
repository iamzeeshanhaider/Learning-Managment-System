<div>
    <section class="container">
        <livewire:alert />

        <div>
            @if ($show_confirmation)
                <div class="modal show" tabindex="-1" role="dialog" style="display: block;">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header border-0">
                                <h5 class="modal-title">Confirm Delete</h5>
                                <button wire:click="$set('show_confirmation', false)" class="close"
                                    data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete this item?
                            </div>
                            <div class="modal-footer border-0">
                                <button wire:click="deleteEvent" class="btn btn-danger">Yes</button>
                                <button wire:click="$set('show_confirmation', false)"
                                    class="btn btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @if (Route::currentRouteName() !== 'sessions')
            <div class="px-3">
                <div class="text-right {{ $show_form ? 'show_event_form' : '' }}">
                    <button class="btn btn-sm btn-primary" type="button" wire:click="toggleForm()">New Session</button>
                </div>

                <div class="shadow {{ $show_form ? 'show' : 'show_event_form' }}">
                    <div class="card border-0 p-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 class="card-title px-2 font-weight-bold">Create Meeting</h2>
                            <button class="btn btn-sm btn-clear text-danger" type="button" wire:click="toggleForm()">
                                <i class="ti-close"></i>
                            </button>
                        </div>

                        <form wire:submit.prevent="saveEvent" class="p-3">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="event_title">Title</label>
                                        <input type="text" wire:model.lazy="title" class="form-control"
                                            id="event_title" placeholder="Enter Title" maxlength="150">
                                        @error('title')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="start_date">Start Date / Time</label>
                                        <input type="datetime-local" wire:model.lazy="start_date" class="form-control"
                                            id="start_date" min="{{ now()->format('Y-m-d\TH:i') }}">
                                        @error('start_date')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="end_date">End Date / Time <span
                                                class="text-muted small">(optional)</span></label>
                                        <input type="datetime-local" wire:model.lazy="end_date" class="form-control"
                                            id="end_date" min="{{ $start_date }}">
                                        @error('end_date')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="description">Description <small
                                                class="text-muted">(Optional)</small></label>
                                        <textarea wire:model.lazy="description" id="description" class="form-control" maxlength="500" rows="2">{{ $description }}</textarea>
                                        @error('description')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex">
                                            <div class="form-check form-switch mx-2">
                                                <input class="form-check-input" type="checkbox"
                                                    wire:model="has_meeting_link" {{ $eventId ? 'disabled' : '' }}
                                                    role="switch" id="hasMeetingLink"
                                                    {{ $has_meeting_link ? 'checked' : '' }}>
                                                <label class="form-check-label" for="hasMeetingLink">Add Meeting
                                                    Link</label>
                                            </div>
                                            <div class="form-check form-switch mx-2">
                                                <input class="form-check-input" type="checkbox"
                                                    wire:model="notify_attendee" role="switch" id="notify_attendee"
                                                    {{ $notify_attendee ? 'checked' : '' }}>
                                                <label class="form-check-label" for="notify_attendee">Notify
                                                    Attendee</label>
                                            </div>
                                        </div>
                                        <button class="btn btn-sm btn-primary" type="submit">
                                            <i class="ti-plus"></i> Save Session
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        @endif

        <div class="container">
            <div class="row mt-3">
                @foreach ($events as $event)
                    <div class="col-md-6">
                        <article class="card rounded shadow border-0 py-4 px-3 iro_card">
                            <div class="d-flex align-items-center w-100">
                                <div class="d-flex flex-column justify-content-center text-center mr-2 p-2 bg-primary rounded-circle text-white"
                                    style="width: 60px; height: 60px">
                                    <span class="h1 pb-0 mb-0 font-weight-bolder" style="margin-bottom: -15px;">
                                        {{ parseDateTime($event['start'])->format('d') }}
                                    </span>
                                    <span
                                        style="margin-top: -10px; font-size: 12px;">{{ parseDateTime($event['end'])->format('M') }}</span>
                                </div>
                                <div class="w-100">
                                    <small>{{ parseDateTime($event['start'])->format('l d F Y') }}</small>
                                    <div class="card-title font-weight-bold h4">{{ $event['name'] }}</div>
                                    <div style="min-height: 80px;">
                                        {{ $expanded ? $event['description'] : str_limit($event['description'], $limit) }}
                                        @if (strlen($event['description']) > $limit)
                                            <button wire:click="toggleExpand" type="button"
                                                class="btn btn-link text-decoration-none btn-sm mx-0 px-0">
                                                {{ $expanded ? 'Show less' : 'Show more' }}
                                            </button>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between pt-3 w-100">
                                        <div class="d-flex">
                                            @foreach ($event['attendees'] as $attendee)
                                                <div class="rounded-circle bg-secondary mr-1"
                                                    title="{{ $attendee['name'] }}"
                                                    style="height: 32px; width: 32px; vertical-align: middle; background-image: url('{{ getAttendeeAvatar($attendee['email']) }}'); background-position: center;  background-repeat: no-repeat; background-size: cover;">
                                                </div>
                                            @endforeach
                                        </div>
                                        <div>
                                            @if ($event['hangoutLink'])
                                                <a href="{{ $event['hangoutLink'] }}" target="_blank"
                                                    class="btn btn-primary btn-sm">Join Session</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ml-auto">
                                @if (canManageSession($event['id']))
                                    <div class="hover_addon">
                                        <button class="btn btn-sm btn-clear text-danger" type="button"
                                            wire:click="editEvent('{{ $event['id'] }}')">
                                            Edit Session <i class="ti-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-clear text-danger" type="button"
                                            wire:click="confirmDelete('{{ $event['id'] }}')">
                                            Delete Session <i class="ti-trash"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
