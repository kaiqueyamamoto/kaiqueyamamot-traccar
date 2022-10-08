@extends('Frontend.Reports.partials.layout')

@section('content')
    @foreach ($report->getItems() as $item)
        <div class="panel panel-default">
            @include('Frontend.Reports.partials.item_heading')

            @if (isset($item['error']))
                @include('Frontend.Reports.partials.item_empty')
            @else

                @if ( ! empty($item['table']))
                    <div class="panel-body no-padding">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>{{ trans('front.time') }}</th>
                                <th>{{ trans('front.event') }}</th>
                                <th>{{ trans('front.position') }}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($item['table']['rows'] as $row)
                                <tr>
                                    <td>{{ $row['time'] }}</td>
                                    <td>{{ $row['message'] }}</td>
                                    <td>{!! $row['location'] !!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                @if( ! empty($item['totals']))
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <td class="col-sm-6">
                                    <table class="table">
                                        <tbody>
                                        @foreach($item['totals'] as $row)
                                            <tr>
                                                <th>{{ $row['title'] }}:</th>
                                                <td>{{ $row['value']}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </td>
                                <td class="col-sm-6">
                                </td>
                            </tr>
                        </table>
                    </div>
                @endif
            @endif
        </div>
    @endforeach
@stop