@if (!empty($groups))

    @foreach ($groups as $group)
        <div class="group" data-toggle="multiCheckbox">
            <div class="group-heading">
                <div class="checkbox">
                    <input type="checkbox" data-toggle="checkbox" value="{{ $group['id'] }}">
                    <label></label>
                </div>

                <div class="group-title {{ $group['open'] ? '' : 'collapsed' }}" data-toggle="collapse" data-target="#geofence-group-{{ $group['id'] }}" data-parent="#geofences_tab" aria-expanded="{{ $group['open'] ? 'true' : 'false' }}" aria-controls="geofence-group-{{ $group['id'] }}">
                    {{ $group['title'] }} <span class="count">{{ $group['geofences']->total() }}</span>
                </div>
            </div>

            <div id="geofence-group-{{ $group['id'] }}" class="group-collapse collapse {{ ! $group['open'] ? '' : 'in' }}" data-id="{{ $group['id'] }}" role="tabpanel" aria-expanded="{{ $group['open'] ? 'true' : 'false' }}">
                <div class="group-body">
                    @include('Frontend.Geofences.items', ['geofences' => $group['geofences']])
                </div>
            </div>
        </div>
    @endforeach
@else
    <p class="no-results">{!! trans('front.no_geofences') !!}</p>
@endif
