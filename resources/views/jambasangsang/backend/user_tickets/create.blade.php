@extends('layouts.backend.master')
@section('content')

@section('breadcrumbs')
<x-bread-crumb pageTitle='Create a Support Ticket' previous="" previousLink="" current="Create Support Tickets" />

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








                    <form class="form-horizontal" role="form" method="POST">
                        {!! csrf_field() !!}



                        <div class="col-md-12">
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <p>Title</p>
                                <input id="title" type="text" class="form-control" placeholder="Title" name="title" value="{{ old('title') }}">

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
                                selected="null"
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
                            <x-select.users name="instructor_id" group="Instructor" :selected="old('instructor_id')" />
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
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>

                                @if ($errors->has('priority'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('priority') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>





                        <div class="col-md-12">
                        <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                            <p>Message</p>

                                <textarea rows="10" id="message" class="form-control" name="message"></textarea>

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
                                    <i class="fa fa-btn fa-ticket"></i> Open Ticket
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
