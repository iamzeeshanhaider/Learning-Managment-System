@extends('layouts.backend.master')
@section('content')

@section('breadcrumbs')
<x-bread-crumb pageTitle='Support Ticket' previous="" previousLink="" current="Support Ticket" />

@endsection

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">

            <div class="row">
                <div class="col-6">
                    <div class="panel-heading">
                        <h6>Subject</h6>
                        <p>{{ $ticket->title }}</p>
                        <h6>Category</h6>
                        <p>{{ $ticket->category->name }}</p>
                         <h6>Instructor</h6>
                        <p>{{ $ticket->instructor->name }}</p>
                    </div>
                </div>
                <div class="col-6">
                    <p>
                        @if ($ticket->status === 'Open')
                            <h6>
                                Status
                            </h6>
                            <span class="label label-success">{{ $ticket->status }}</span>
                        @else
                            <h6>
                                Status
                            </h6> <span class="label label-danger">{{ $ticket->status }}</span>
                        @endif
                    </p>
                    <h6>
                        Created on
                    </h6>
                    <p>{{ $ticket->created_at->diffForHumans() }}</p>
                </div>
            </div>

            <div class="ticket-info">
                <h6>Message</h6>
                <p>{{ $ticket->message }}</p>
            </div>


            <div class="panel-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
            </div>
        </div>

        <hr>

        @include('jambasangsang.backend.tickets.comments')

        <hr>

        @include('jambasangsang.backend.tickets.reply')

    </div>
</div>


@endsection
