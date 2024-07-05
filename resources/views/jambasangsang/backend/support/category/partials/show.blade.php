<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                <p class="card-text">Name:</p>
                <h5 class="card-title">{{ $ticket_category->name }}</h5>
            </div>
        </div>

        <div class="weather-category twt-category">
            <ul>
                <li>
                    <a href="#" title="Created By">
                        <span class="h6">{{ $ticket_category->created_by->name }}</span>
                        <br>
                        Created By
                    </a>
                </li>
                <li>
                    <a href="#" title="Created At">
                        <span class="h6">{{ $ticket_category->created_at }}</span>
                        <br>
                        Created At
                    </a>
                </li>
                <li>
                    <a href="#" title="Total Tickets">
                        {!! formatCount(count($ticket_category->tickets)) !!}
                        <br>
                        Total Tickets
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
