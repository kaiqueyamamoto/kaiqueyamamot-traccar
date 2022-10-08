<div id="widget-location" class="widget widget-device">
    <div class="widget-heading">
        <div class="widget-title">
            <i class="icon address"></i> {{ trans('front.location') }}
        </div>
    </div>

    <div class="widget-body">
        <table class="table">
            <tbody>
            <tr>
                <td>{{ trans('front.city') }}:</td>
                <td>{{ $location['city'] or '-' }}</td>
            </tr>
            <tr>
                <td>{{ trans('front.road') }}:</td>
                <td>{{ $location['road'] or '-' }}</td>
            </tr>
            <tr>
                <td>{{ trans('front.house') }}:</td>
                <td>{{ $location['house'] or '-' }}</td>
            </tr>
            <tr>
                <td>{{ trans('front.zip') }}:</td>
                <td>{{ $location['zip'] or '-' }}</td>
            </tr>
            </tbody>
        </table>
        <table class="table">
            <tbody>
            <tr>
                <td>{{ trans('front.country') }}:</td>
                <td>{{ $location['country'] or '-' }}</td>
            </tr>
            <tr>
                <td>{{ trans('front.county') }}:</td>
                <td>{{ $location['county'] or '-' }}</td>
            </tr>
            <tr>
                <td>{{ trans('front.state') }}:</td>
                <td>{{ $location['state'] or '-' }}</td>
            </tr>
            <tr>
                <td>{{ trans('front.address') }}:</td>
                <td>
                    @if ( ! (empty($location['lat']) && empty($location['lng'])))
                        <span class="pull-right p-relative">
                        <a href="//maps.google.com/maps?q={{ $location['lat'] }},{{ $location['lng'] }}&amp;t=m&amp;hl=en" target="_blank" class="btn btn-xs btn-default"><i class="icon eye"></i></a>
                    </span>
                    @endif
                    {{ $location['address'] or '-' }}
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>