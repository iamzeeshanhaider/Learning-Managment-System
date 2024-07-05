@extends('layouts.backend.master')
@section('content')

    <style>
        .chat-messages {
            display: flex;
            flex-direction: column-reverse;
            min-height: 60vh;
            max-height: 80vh;
            height: 100%;
            overflow-y: scroll;
        }

        .chat-messages ::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            background-color: #F5F5F5;
        }

        .chat-messages ::-webkit-scrollbar {
            width: 12px;
            background-color: #F5F5F5;
        }

        .chat-message-container {
            display: flex;
            flex-direction: column-reverse;
        }

        .chat-message-left,
        .chat-message-right {
            display: flex;
            width: 75%;
            align-items: start;
            max-width: max-content;
        }

        .chat-message-left {
            margin-right: auto;
        }

        .chat-message-right {
            flex-direction: row-reverse;
            margin-left: auto;
        }
    </style>

@section('breadcrumbs')
    <x-bread-crumb pageTitle='Support Ticket' previous="Tickets" previousLink="{{ route('tickets.index') }}"
        current="Support Ticket" />
@endsection

<main class="content">
    <div class="container p-0">
        <div class="card border-0">
            <div class="row">
                <div class="border-right col-md-4">
                    <div class="card-header bg-light border-bottom d-flex justify-content-between">
                        <div class="card-title">
                            <p class="">
                                {{ $ticket->category->name }} <br>
                                <small><em>Category</em></small>
                            </p>
                        </div>
                        <div class="">
                            <p class="">
                                <span
                                    class="badge badge-pill badge-{{ $ticket->status_color() }}">{{ $ticket->status_name ?? $ticket->status }}</span>
                                <br>
                                <small><em>Status</em></small>
                            </p>
                        </div>
                    </div>
                    <div class="">
                        <div class="shadow p-3 m-3">
                            <strong>Assigned Instructor:</strong>
                            <x-partials.user_profile :user="$ticket->instructor" />
                        </div>

                        <div class="shadow p-3 m-3">
                            <strong>Message:</strong>
                            {!! $ticket->message !!}
                        </div>

                        @if ($ticket->image)
                            <div class="shadow p-3 m-3">
                                <strong>Attachment:</strong>
                                <a onclick="handleGeneralModal(this)" class="text-white"
                                    data-link="{{ route('tickets.edit', ['ticket' => $ticket->slug, 'view' => 'preview_image']) }}"
                                    title="Edit Ticket">
                                    <img src="{{ $ticket->image() }}" alt="">
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="py-2 px-4 border-bottom d-none d-lg-block">
                        <div class="d-flex align-items-center justify-content-between py-2">
                            <div>
                                <strong>Ticket Initator:</strong> <br>
                                <x-partials.user_profile :user="$ticket->user" />
                            </div>

                            <div>
                                @if (auth()->user()->can('update', $ticket))
                                    <a onclick="handleGeneralModal(this)" class="text-white btn btn-sm btn-primary"
                                        data-link="{{ route('tickets.edit', $ticket->slug) }}" title="Edit Ticket">
                                        <i class="fa fa-edit"></i> Update Ticket
                                    </a>
                                @endif

                            </div>
                        </div>
                    </div>

                    <livewire:backend.support.ticket-comment :ticket='$ticket' />

                </div>
            </div>
        </div>
    </div>
</main>

@endsection
