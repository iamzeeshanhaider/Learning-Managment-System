@extends('layouts.backend.master')
@section('content')

@section('breadcrumbs')
<x-bread-crumb pageTitle='Update Support Ticket' previous="" previousLink="" current="Update Support Ticket" />

@endsection

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">

            <div class="panel-body">


                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif








                <form class="form-horizontal" role="form" method="POST"
                action="{{route('update_ticket', [$ticket])}}"
                >
                    {!! csrf_field() !!}



                    <div class="col-md-12">
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <p>Title</p>
                            <input id="title" type="text" class="form-control" placeholder="Title" name="title"
                                value="{{ isset($ticket) ? $ticket->title : old('title') }}">

                            @if ($errors->has('title'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>






                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                            <x-select.ticket-category
                                :selected="$ticket->category_id"
                            />
                            @if ($errors->has('category'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('category') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>




                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('instructor') ? ' has-error' : '' }}">
                            <x-select.users name="instructor_id" group="Instructor" :selected="isset($ticket) ? $ticket->instructor_id : old('instructor_id')" />
                            @if ($errors->has('instructor'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('instructor') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>









                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
                            <p>Priority</p>

                            <select id="priority" type="" class="form-control" name="priority">
                                <option value="">Select Priority</option>
                                <option value="low"
                                    @isset($ticket) {{ is_selected('low', $ticket->priority) }} @endisset>
                                    Low</option>
                                <option value="medium"
                                    @isset($ticket) {{ is_selected('medium', $ticket->priority) }} @endisset>
                                    Medium</option>
                                <option value="high"
                                    @isset($ticket) {{ is_selected('high', $ticket->priority) }} @endisset>
                                    High</option>
                            </select>

                            @if ($errors->has('priority'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('priority') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>



                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                            <p>Status</p>

                            <select id="status" type="" class="form-control" name="status">
                                <option value="">@lang('Select Status')</option>
                                <option value="open"
                                    @isset($ticket) {{ is_selected('open', $ticket->status) }} @endisset>
                                    @lang('Open')</option>
                                <option value="closed"
                                    @isset($ticket) {{ is_selected('closed', $ticket->status) }} @endisset>
                                    @lang('Closed')</option>
                                <option value="resolved"
                                    @isset($ticket) {{ is_selected('resloved', $ticket->status) }} @endisset>
                                    @lang('Resolved')</option>
                            </select>

                            @if ($errors->has('status'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('status') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>





                    <div class="col-md-12">
                        <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                            <p>Message</p>

                            <textarea rows="10" id="message" class="form-control" name="message"><?= $ticket->message ?> </textarea>

                            @if ($errors->has('message'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('message') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>



                    <div class="col-md-6 col-md-offset-4">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-ticket"></i> Update Ticket
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection


<script>
    var instructors = "{{ $instructors }}";
    console.log(JSON.stringify(instructors));
</script>
