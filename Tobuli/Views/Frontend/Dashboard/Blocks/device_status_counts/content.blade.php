<table class="table">
    <tbody>
    <tr>
        <td class="text-left">{{ trans('front.count') }}</td>
        <td class="text-right"><b>{{ $devices }}</b></td>
    </tr>
    <tr>
        <td class="text-left">{{ trans('global.online') }}</td>
        <td class="text-right"><b>{{ $online }}</b></td>
    </tr>
    <tr>
        <td class="text-left">{{ trans('front.offline') }}</td>
        <td class="text-right"><b>{{ $offline }}</b></td>
    </tr>
    <tr>
        <td class="text-left">{{ trans('front.never_connected') }}</td>
        <td class="text-right"><b>{{ $never_connected }}</b></td>
    </tr>
    <tr>
        <td class="text-left">{{ trans('front.expired') }}</td>
        <td class="text-right"><b>{{ $expired }}</b></td>
    </tr>
    </tbody>
</table>