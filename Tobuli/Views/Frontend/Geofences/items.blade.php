<ul class="group-list">
@foreach ($geofences as $key => $item)
    @include('Frontend.Geofences.item')
@endforeach
</ul>

@if ($geofences->nextPageUrl())
    <form onSubmit="app.geofences.listPage('{!! $geofences->nextPageUrl() !!}', this); return false;" class="text-center">
        <button class="btn btn-default btn-xs">
            <i class="fa fa-refresh"></i> {{ trans('front.show_more') }}
        </button>
    </form>
@endif