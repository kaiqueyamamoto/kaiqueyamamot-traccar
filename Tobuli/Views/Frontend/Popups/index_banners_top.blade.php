@if (Auth::check())
    @foreach(Auth::user()->topBars() as $topBar)
        <div class="banner" id="banner-{{ $topBar->id }}">
            {!! $topBar->content !!}
        </div>
    @endforeach
@endif
