<ul class="group-list">
@foreach ($devices as $key => $item)
    @include('Frontend.Objects.item')
@endforeach
</ul>

@if ($devices->nextPageUrl())
    <form onSubmit="app.devices.listPage('{!! $devices->nextPageUrl() !!}', this); return false;" class="text-center">
        <button class="btn btn-default btn-xs">
            <i class="fa fa-refresh"></i> {{ trans('front.show_more') }}
        </button>
    </form>
@endif