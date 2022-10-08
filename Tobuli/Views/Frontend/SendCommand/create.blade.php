@extends('Frontend.Layouts.modal')

@section('title')
    <i class="icon send-command"></i> {!!trans('front.send_command')!!}
@stop

@section('body')
    <ul class="nav nav-tabs nav-default" role="tablist">
        <li class="active"><a href="#command-form-gprs" role="tab" data-toggle="tab">{!!trans('front.gprs')!!}</a></li>
        <li><a href="#command-form-sms" role="tab" data-toggle="tab">{!!trans('front.sms')!!}</a></li>
        <li><a href="#schedule" role="tab" data-toggle="tab">{!!trans('front.schedule')!!}</a></li>
    </ul>

    {!!Form::open(['route' => 'send_command.store', 'method' => 'POST'])!!}
    {!!Form::hidden('id')!!}
    <div class="alert alert-success" role="alert" style="display: none;">{!!trans('front.command_sent')!!}</div>
    <div class="alert alert-danger main-alert" role="alert" style="display: none;"></div>
    <div class="alert alert-warning main-alert" role="alert" style="display: none;">
        <div id="warnings_accordion" role="tablist" aria-multiselectable="true" hidden>
            <a class="icon ico-arrow-down pull-right" role="button" data-toggle="collapse" data-parent="#warnings_accordion" href="#collapse_warnings" aria-controls="collapse_warnings"></a>
            <div id="collapse_warnings" class="collapse out" role="tabpanel" hidden></div>
        </div>
    </div>

    <div class="tab-content">

        <div id="command-form-gprs" class="tab-pane active connection-tab" data-url="{!!route('send_command.gprs')!!}">
            @include('Frontend.SendCommand.partials.gprs_form')
        </div>

        <div id="command-form-sms" class="tab-pane" data-url="{!!route('send_command.store')!!}">
            @include('Frontend.SendCommand.partials.sms_form')
        </div>

        <div id="schedule" class="tab-pane">
            @include('Frontend.SendCommand.schedule.table')
        </div>

    </div>

    {!!Form::close()!!}

    <script>
        $(document).ready(function () {
            $('#send_command select[name="type"], #command_schedule select[name="type"]').trigger('change');
            $('#send_command select[name="device_id[]"], #command_schedule select[name="device_id[]"]').trigger('change');

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $("button.command-save").attr('disabled', $(e.target).attr("href") == '#schedule');
            });
        });

        if (typeof _static_send_command === "undefined") {
            var _static_send_command = true;

            var sendCommands = new Commands();

            $(document).on('change', '#send_command select[name="type"], #command_schedule select[name="type"]', function () {
                var type = $(this).val();
                var container = $(this).closest('.modal');

                sendCommands.buildAttributes(type, container.find('.attributes'));
            });

            $(document).on('change', 'select[name="sms_template_id"]', function () {
                var url = $(this).data('url');
                var val = $(this).val();
                var container = $(this).closest('.modal');
                var sms_textarea = container.find('textarea[name="message_sms"]');

                if (val == 0) {
                    container.find('input[name="message_sms"]').val('');
                    return;
                }

                $.ajax({
                    type: 'POST',
                    dataType: "html",
                    data: {
                        id: val
                    },
                    url: url,
                    beforeSend: function ()
                    {
                        sms_textarea.attr('disabled', 'disabled');
                    },
                    success: function (res)
                    {
                        sms_textarea.val(res);
                    },
                    complete: function ()
                    {
                        sms_textarea.removeAttr('disabled').selectpicker('refresh');
                    }
                });
            });

            $(document).on('change', '#send_command select[name="device_id[]"], #command_schedule select[name="device_id[]"]', function () {
                var command_type_element = $(this).closest('.modal').find('.send-command-type');

                sendCommands.getDeviceCommands(
                    $(this).val(),
                    function ()
                    {
                        $(this).attr('disabled', 'disabled');
                        loader.add(command_type_element);
                    },
                    function ()
                    {
                        sendCommands.buildTypesSelect(command_type_element.find('select'));
                        $(this).removeAttr('disabled');
                        loader.remove(command_type_element);
                    }
                );
            });

            $(document).on('click', '#send_command button.btn.command-save', function () {
                var url = $('#send_command .tab-pane.active').data('url');
                $('#send_command form').attr('action', url);
                $('#send_command button.update_hidden').trigger('click');
                $('#send_command .alert-success').css('display', 'none');
            });

            $(document).on('send_command', function (e, res) {
                var container = $(this).closest('.modal');

                var alerts = ['alert-success', 'alert-warning', 'alert-danger'];

                for (i in alerts)
                    $('#send_command .' + alerts[i] + ', #command_schedule .' + alerts[i]).css('display', 'none');

                if (res.error) {
                    $('#send_command .alert-danger, #command_schedule .alert-danger').css('display', 'block').html(res.error);
                }
                else if (res.warnings) {
                    $('#send_command .alert-warning').css('display', 'block');
                }
                else {
                    $('#send_command .alert-success, #command_schedule .alert-success').css('display', 'block').html(res.message);
                }
            });

            tables.set_config('schedule', {
                url:'{{ route('command_schedules.index') }}',
            });

            function command_schedule_modal_callback() {
                tables.get('schedule');
            }
        }
    </script>
@stop

@section('buttons')
    <button type="button" class="update_hidden" style="display: none;"></button>
    <button type="button" class="btn btn-action command-save">{!!trans('front.send')!!}</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">{!!trans('global.cancel')!!}</button>
@stop