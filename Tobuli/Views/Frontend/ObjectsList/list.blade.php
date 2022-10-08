<table class="table table-list">
    <thead>
    <tr>
        @foreach($columns as $column)
            @if($column['field'] == 'fuel')
                <th colspan="3">{{ $column['title'] }}</th>
            @else
                <th rowspan="2">{{ $column['title'] }}</th>
            @endif
        @endforeach
    </tr>
    @foreach($columns as $column)
        @if($column['field'] == 'fuel')
        <tr>
            <th>{{ trans('global.percentage') }}</th>
            <th>{{ trans('global.quantity') }}</th>
            <th>{{ trans('global.price') }}</th>
        </tr>
        @endif
    @endforeach
    </thead>
    <tbody>
    @foreach($grouped as $key => $devices)
        @foreach($devices as $device)
        <tr>
            @foreach($columns as $column)
            <td>
                @if($column['field'] == 'status')
                <span class="device-status" style="background-color: {{ $device['status_color'] }};" title="{{ trans('global.'.$device['status']) }}"></span>
                @elseif($column['field'] == 'position')
                    @if ($device['lat'] && $device['lng'])
                    <a href="http://maps.google.com/maps?q={{ $device['lat'] }},{{ $device['lng'] }}&t=m" target="_blank">
                    {{ $device['lat'] }}&deg;, {{ $device['lng'] }}&deg;
                    </a>
                    @endif
                @elseif($column['field'] == 'fuel')
                    {{ $device['fuel']['col1'] }}</td>
                    <td>{{ $device['fuel']['col2'] }}</td>
                    <td>{{ $device['fuel']['col3'] }}
                @else
                    <?php $color = !empty($device['color'][$column['field']]) ? $device['color'][$column['field']] : 'inherit'; ?>
                    <span style="color: {{ $color }};">{{ $device[$column['field']] or '-' }}</span>
                @endif
            </td>
            @endforeach
        </tr>
        @endforeach
    @endforeach
    </tbody>
</table>