<div>
    <!-- Button trigger modal -->
    <div class="p-2">
        <div class="custom-drop-select dropup" id="attendance-checkin">
            <a class="dropdown-toggle text-black" href="#" data-toggle="dropdown" id="attendance" aria-haspopup="true"
                aria-expanded="false">
                @if ($hasCheckedIn)
                    <span class="iro_badge light_badge">
                        <i class="ti-check-box"></i> Checked In
                    </span>
                @else
                    <span class="iro_badge solid_badge">
                        <i class="ti-check-box"></i> Check In
                    </span>
                @endif
            </a>

            <div class="dropdown-menu m-0 p-0" aria-labelledby="attendance">
                <div class="card border-0 p-3">
                    <h5>Attendance Checkin</h5>
                    <form wire:submit.prevent='persistAttendance'>
                        <div class="row p-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="mb-1" for="date">@lang('Date'):</label>
                                    <input class="form-control" id="date" type="date" wire:model.defer="date" readonly max='{{ date('Y-m-d') }}'>
                                    @error('date')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-1" for="time_in">@lang('Time In'):</label>
                                    <input class="form-control" id="time_in" type="time"
                                        wire:model.defer="time_in">
                                    @error('time_in')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-1" for="time_out">@lang('Time Out'):</label>
                                    <input class="form-control" id="time_out" type="time"
                                        wire:model.defer="time_out">
                                    @error('time_out')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
