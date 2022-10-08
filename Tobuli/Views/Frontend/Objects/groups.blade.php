@if (!empty($groups))
    @foreach ($groups as $group)
        <div class="group" data-toggle="multiCheckbox">
            <div class="group-heading">

                <div class="checkbox">
                    <input type="checkbox" data-toggle="checkbox" value="{{ $group['id'] }}">
                    <label></label>
                </div>

                <div class="group-title {{ $group['open'] ? '' : 'collapsed' }}" data-toggle="collapse" data-target="#device-group-{{ $group['id'] }}" data-parent="#objects_tab" aria-expanded="{{ $group['open'] ? 'true' : 'false' }}" aria-controls="device-group-{{ $group['id'] }}">
                    {{ $group['title'] }} <span class="count">{{ $group['devices']->total() }}</span>
                </div>

                <div class="btn-group">
                    @if ($group['id'])
                        <i class="btn icon options" data-url="{{ route('devices_groups.edit', $group['id']) }}" data-modal="devices_groups_edit"></i>
                    @else
                        <i class="btn icon options" data-url="{{ route('devices_groups.create') }}" data-modal="devices_groups_create"></i>
                    @endif
                </div>
            </div>


            <div id="device-group-{{ $group['id'] }}" class="group-collapse collapse {{ ! $group['open'] ? '' : 'in' }}" data-id="{{ $group['id'] }}" role="tabpanel" aria-expanded="{{ $group['open'] ? 'true' : 'false' }}">
                <div class="group-body">

                        @include('Frontend.Objects.items', ['devices' => $group['devices']])

                </div>
            </div>
        </div>
    @endforeach
@else
    <p class="no-results">{!! trans('front.no_devices') !!}</p>
@endif
