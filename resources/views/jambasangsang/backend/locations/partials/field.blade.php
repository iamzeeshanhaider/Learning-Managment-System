@section('css')
    {{--  --}}
@show

<div class="animated fadeIn">
    <form action="{{ isset($location) ? route('locations.update', $location->slug) : route('locations.store') }}"
        method="POST" enctype="multipart/form-data" onsubmit="$('#location-button').attr('disabled', true)">
        @csrf
        @if (isset($location))
            @method('put')
        @endif
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <x-select.location-type :selected="isset($location) ? $location->type : \App\Enums\LocationTypes::Physical" />
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <x-select.status :selected="isset($location) ? $location->status : \App\Enums\GeneralStatus::Enabled" />
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group has-success">
                    <label for="name" class="mb-1 control-label">@lang('Name')</label>
                    <input id="name" name="name" type="text" class="form-control name valid"
                        autocomplete="name" required value="{{ old('name', isset($location) ? $location->name : '') }}"
                        placeholder="Specify platform for online location (e.g. zoom)" maxlength="150">
                    <span class="help-block field-validation-valid" data-valmsg-for="name"
                        data-valmsg-replace="true"></span>
                </div>
            </div>

            <div class="col-md-12 p-0 m-0" id="seat_capacity_container"
                data-type={{ isset($location) ? $location->type : null }}>
                <div class="col-md-6" id="">
                    <div class="form-group has-success">
                        <label for="seat_capacity" class="mb-1 control-label">@lang('Seat Capacity')</label>
                        {{ old('seat_capacity') }}
                        <input id="seat_capacity" name="seat_capacity" type="number"
                            class="form-control seat_capacity valid" autocomplete="seat_capacity" min="0"
                            value="{{ old('seat_capacity', isset($location) ? $location->seat_capacity : '0') }}">
                        <span class="help-block field-validation-valid" data-valmsg-for="seat_capacity"
                            data-valmsg-replace="true"></span>
                    </div>
                </div>
                @if (isset($location))
                    <div class="col-md-6">
                        <div class="form-group has-success">
                            <label for="remaining_seat" class="mb-1 control-label">@lang('Remaining Seat')</label>
                            {{ old('remaining_seat') }}
                            <input id="remaining_seat" name="remaining_seat" type="number"
                                class="form-control remaining_seat valid" autocomplete="remaining_seat"
                                value="{{ old('remaining_seat', isset($location) && $location->remaining_seat > 0 ? $location->remaining_seat : $location->seat_capacity) }}"
                                max="{{ $location->seat_capacity ?? 0 }}">
                            <span class="help-block field-validation-valid" data-valmsg-for="remaining_seat"
                                data-valmsg-replace="true"></span>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-md-12">
                <div class="form-group has-success">
                    <x-editor id="location_description" value="{!! isset($location) ? $location->description : old('description') !!}" />
                </div>
            </div>

        </div>
        <div>
            <button id="location-button" type="submit" class="btn btn-lg btn-primary btn-block">
                <span id="location-button-sending">
                    @isset($location)
                        @lang('Update Location')
                    @else
                        @lang('Create Location')
                    @endisset
                </span>&nbsp;
                <i class="fa fa-arrow-right fa-lg"></i>
            </button>
        </div>
    </form>
</div>

<script>
    $('document').ready(function() {
        var seat_capacity = $('#seat_capacity_container');
        var loc_type = seat_capacity.data('type');
        seat_capacity.hide(200);

        if (loc_type && loc_type === 'online') {
            seat_capacity.hide(200)
        } else {
            seat_capacity.show(200)
        }
        $("#location_type").change(function() {
            var selected_loc_type = $(this).val();
            if (selected_loc_type === 'online') {
                seat_capacity.hide(200)
            } else {
                seat_capacity.show(200)
            }
        });
    });
</script>
