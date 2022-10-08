@extends('Frontend.Reports.partials.layout')

@section('content')
    @foreach ($report->getItems() as $item)
        <div class="panel panel-default">
            @include('Frontend.Reports.partials.item_heading')

            @if (isset($item['error']))
                @include('Frontend.Reports.partials.item_empty')
            @else

            <div class="panel-body">
                @foreach($item['sensors'] as $sensor)
                    @include('Frontend.Reports.partials.item_sensor_data')
                @endforeach
            </div>

            @endif
        </div>
    @endforeach
@stop

@section('scripts')
    <style>
        .demo-placeholder {
            width: 100%;
            height: 150px;
            font-size: 14px;
            line-height: 1.2em;
        }
        .graph-control {
            height: 40px;
        }
        .graph-control-label {
            float: right;
        }
        .graph-control {
            height: 27px;
        }
        .graph-control li {
            display: inline;
        }
        .graph-control-buttons {
            float: right;
            margin-left: 10px;
        }
        .graph-control-buttons img {
            cursor: pointer;
        }
    </style>
    <script>{!! file_get_contents(public_path('assets/js/report.js')) !!}</script>
    <script>
        var plots = {};
        var options = {
            colors: ["rgba(76, 84, 84, 1)"],
            series: {
                shadowSize: 0
            },
            crosshair: {
                mode: "x"
            },
            lines: {
                show: true,
                lineWidth: 1.5,
                lineColor: 'red',
                fill: true,
                fillColor: "rgba(76, 84, 84, 0.4)"

                // steps: e
            },
            /*selection: {
             mode: "x"
             },*/
            zoom: {
                interactive: false
            },
            pan: {
                interactive: true
            },
            xaxis: {
                minTickSize: [30, "minute"],
                mode: 'time',
                twelveHourClock: false,
            },
            yaxis: {
                tickFormatter: function(value, axis) { return value.toFixed(axis.tickDecimals) + 'L'; },
                minTickSize: 1,
                tickDecimals: 0,
                zoomRange: false

            },
            legend: {
                noColumns: 0,
                labelFormatter: function (label, series) {
                    return "<font color=\"white\">" + label + "</font>";
                },
                backgroundColor: "#000",
                backgroundOpacity: 1.0,
                labelBoxBorderColor: "#000000",
                position: "nw"
            },
            grid: {
                color: "#999999",
                margin: {
                    top: 10,
                    left: 10,
                    bottom: 10,
                    right: 10
                },
                hoverable: true,
                borderWidth: 1,
                borderColor: '#DDDDDD'
            }
        };
    </script>
@stop