@extends('Frontend.Layouts.modal')
@section('modal_class', 'modal-lg')

@section('title')
    <i class="icon icon-fa fa-clock-o"></i> {!!trans('front.command_schedule')!!}
@stop

@section('body')
    {!!Form::open(['route' => 'command_schedules.store', 'method' => 'POST'])!!}
    {!!Form::hidden('event', 'command')!!}

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!!Form::label('connection', trans('front.connection') . ':')!!}
                {!!Form::select('connection', $connections, null, ['class' => 'form-control', 'id' => 'connection'])!!}
            </div>

            <div class="connection" id="gprs" hidden>
                @include('Frontend.SendCommand.partials.gprs_form')
            </div>

            <div class="connection" id="sms" hidden>
                @include('Frontend.SendCommand.partials.sms_form')
            </div>
        </div>

        <div class="col-md-6">
            @include('Frontend.Schedules.create_fields')
        </div>
    </div>

    {!!Form::close()!!}
@stop

<script type="text/javascript">
    $(document).ready(function () {
        $('#connection').on('change', function (e) {
            var connection = e.target.value;

            $('.connection').each(function () {
                if ($(this).attr('id') == connection)
                    return $(this).show();

                return $(this).hide();
            });
        }).trigger('change');
    });
</script>