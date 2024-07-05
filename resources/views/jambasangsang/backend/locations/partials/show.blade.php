<div class="card">
    <div class="card-body">
        <h5 class="mt-3 card-title">Name:</h5>
        <span class="card-title">{!! $location->name !!}</span>

        <h5 class="mt-3 card-title">Description:</h5>
        <span class="card-title">{!! $location->description !!}</span>

        <div class="weather-category twt-category">
            <hr>
            <ul>
                <li class="active">
                    <a href="#" title="Status">
                        <span class="h6 text-{{ $location->status_color() }}">{{ $location->status }}</span>
                        <br>
                        Status
                    </a>
                </li>
                <li>
                    <a href="#" title="Seat Capacity">
                        <span class="h5">{{ $location->seat_capacity }}</span>
                        <br>
                        Seat Capacity
                    </a>
                </li>
                <li>
                    <a href="#" title="Remaining Seat">
                        <span class="h5">{{ $location->remaining_seat }}</span>
                        <br>
                        Remaing Seat
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
