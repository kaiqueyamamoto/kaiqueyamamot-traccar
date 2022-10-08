@if (!empty($groups))

    @foreach ($groups as $group)
        <div class="group" data-toggle="multiCheckbox">
            <div class="group-heading">

                <div class="checkbox">
                    <input type="checkbox" data-toggle="checkbox" value="{{ $group['id'] }}">
                    <label></label>
                </div>

                <div class="group-title {{ $group['open'] ? '' : 'collapsed' }}" data-toggle="collapse" data-target="#poi-group-{{ $group['id'] }}" data-parent="#objects_tab" aria-expanded="{{ $group['open'] ? 'true' : 'false' }}" aria-controls="poi-group-{{ $group['id'] }}">
                    {{ $group['title'] }} <span class="count">{{ $group['pois']->total() }}</span>
                </div>

                <div class="btn-group">
                    @if ($group['id'])
                        <i class="btn icon options" data-url="{{ route('pois_groups.edit', $group['id']) }}" data-modal="pois_groups_edit"></i>
                    @else
                        <i class="btn icon options" data-url="{{ route('pois_groups.create') }}" data-modal="pois_groups_create"></i>
                    @endif
                </div>
            </div>

            <div id="poi-group-{{ $group['id'] }}" class="group-collapse collapse {{ ! $group['open'] ? '' : 'in' }}" data-id="{{ $group['id'] }}" role="tabpanel" aria-expanded="{{ $group['open'] ? 'true' : 'false' }}">
                <div class="group-body">

                        @include('Frontend.Pois.items', ['pois' => $group['pois']])

                </div>
            </div>
        </div>
    @endforeach
@else
    <p class="no-results">{!! trans('front.no_map_icons') !!}</p>
@endif
