<ul class="group-list">
@foreach ($pois as $key => $item)
    @include('Frontend.Pois.item')
@endforeach
</ul>

@if ($pois->nextPageUrl())
    <form onSubmit="app.pois.listPage('{!! $pois->nextPageUrl() !!}', this); return false;" class="text-center">
        <button class="btn btn-default btn-xs">
            <i class="fa fa-refresh"></i> {{ trans('front.show_more') }}
        </button>
    </form>
@endif