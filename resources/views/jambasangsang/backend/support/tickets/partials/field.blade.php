@section('css')
    {{--  --}}
@show

<div class="animated fadeIn">
    @if ($view && $view === 'preview_image')
        <div class="border-0">
            <img class="" src="{{ $ticket->image() . '#toolbar=0&navpanes=0&scrollbar=0' }}"
                style="width: 100%; height: auto;" />
        </div>
    @else
        <form action="{{ isset($ticket) ? route('tickets.update', $ticket) : route('tickets.store') }}" method="post"
            enctype="multipart/form-data" onsubmit="$('#ticket-button').attr('disabled', true)">
            @csrf
            @isset($ticket)
                @method('put')
            @endisset

            <div class="row">

                @if (
                    !isset($ticket) ||
                        auth()->user()->isStudent())
                    <div class="col-12 mb-3">
                        <x-select.ticket-category :selected="isset($ticket) ? $ticket->category->id : ''" />
                        @error('category_id')
                            <div class="help-block field-validation-valid alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <x-editor id="ticket_message" value="{!! isset($ticket) ? $ticket->message : old('description') !!}" label="Message"
                            fieldName="message" />
                        @error('message')
                            <div class="help-block field-validation-valid alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <div class="form-group">
                            <label for="image" class="mb-1 control-label">@lang('Screenshot')</label>
                            <input id="image" name="image" type="file"
                                accept="image/png, image/gif, image/jpeg"
                                value="{{ isset($ticket) ? $ticket->image : old('image') }}"
                                class="form-control image @error('image') is-invalid @enderror" autocomplete="image">
                        </div>
                        @error('image')
                            <div class="help-block field-validation-valid alert alert-danger">
                                {{ $message }}</div>
                        @enderror
                    </div>
                @endif

                @if (
                    !isset($ticket) &&
                        !auth()->user()->isStudent())
                    <div class="col-12 mb-3">
                        <x-select.users group="Student" label="Assign to Student" name="user_id" :selected="isset($ticket) ? $ticket->instructor_id : old('user_id')" />
                        @error('user_id')
                            <div class="help-block field-validation-valid alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                @endif

                @if (
                    !auth()->user()->isStudent() ||
                        (isset($ticket) &&
                            auth()->user()->can('update', $ticket)))
                    <div class="col-12 mb-3">
                        <x-select.users group="Instructor" label="Assign to Instructor" name="instructor_id"
                            :selected="isset($ticket) ? $ticket->instructor_id : old('instructor_id')" />
                        @error('instructor_id')
                            <div class="help-block field-validation-valid alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="ticket_status" class="mb-1 control-label">Status</label>
                            <div class="input-group">
                                <select name="status" id="ticket_status" class="form-control" required>
                                    <option value="" selected disabled>-- Select Status --</option>
                                    @foreach (['open', 'closed'] as $status)
                                        <option
                                            value="{{ $status }}"{{ isset($ticket) && strtolower($status) === strtolower($ticket->status) ? ' selected' : '' }}>
                                            {{ ucwords($status) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('status')
                                <div class="help-block field-validation-valid alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-6">
                            <label for="ticket_priority" class="mb-1 control-label">Priority</label>
                            <div class="input-group">
                                <select name="priority" id="ticket_priority" class="form-control" required>
                                    <option value="" selected disabled>-- Select Priority --</option>
                                    @foreach (['low', 'medium', 'high'] as $priority)
                                        <option
                                            value="{{ $priority }}"{{ isset($ticket) && strtolower($priority) === strtolower($ticket->priority) ? ' selected' : '' }}>
                                            {{ ucwords($priority) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('priority')
                                <div class="help-block field-validation-valid alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                @endif

            </div>

            <div>
                <button id="ticket-button" type="submit" class="btn btn-lg btn-primary btn-block">
                    <i class="fa fa-save fa-lg"></i>&nbsp;
                    <span>{{ isset($ticket) ? __('Update') : __('Create') }}</span>
                </button>
            </div>
        </form>

    @endif

</div>
