<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>{{ $pageTitle }}</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="text-right breadcrumb">
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    @if ($previousLink)
                        <li><a href="{{ $previousLink }}" title="{{ $previous }}">{{ str_limit($previous, 30) }}</a></li>
                    @endif
                    <li class="active" title="{{ $current }}">{{ str_limit($current, 30) }}</li>
                </ol>
                {!! $slot !!}
            </div>
        </div>
    </div>
</div>



