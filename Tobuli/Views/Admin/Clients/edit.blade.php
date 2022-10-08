@extends('Frontend.Layouts.modal')

@section('title')
    <i class="icon user"></i> {{ trans('global.edit') }}
@stop

@section('body')
    <ul class="nav nav-tabs nav-default" role="tablist">
        <li class="active"><a href="#client-edit-form-main" role="tab" data-toggle="tab">{{ trans('front.main') }}</a></li>
        <li><a href="#client-edit-form-permissions" role="tab" data-toggle="tab">{{ trans('validation.attributes.permissions') }}</a></li>
        <li><a href="#client-edit-form-objects" role="tab" data-toggle="tab">{{ trans('front.objects') }}</a></li>
        @if (settings('plugins.user_api_tab.status'))
            <li><a href="#client-edit-form-api" role="tab" data-toggle="tab">{{ trans('front.api') }}</a></li>
        @endif
        @if ($item->hasCustomFields())
            <li><a href="#user-custom-fields" role="tab" data-toggle="tab">{!!trans('admin.custom_fields')!!}</a></li>
        @endif
        @if (settings('plugins.object_listview.status'))
            <li><a href="#client-edit-form-listview" role="tab" data-toggle="tab">{{ trans('front.object_listview') }}</a></li>
        @endif
    </ul>

    {!! Form::open(array('route' => 'admin.clients.update', 'method' => 'PUT')) !!}
    <input style="display:none" type="text" name="fakeusernameremembered"/>
    <input style="display:none" type="password" name="fakepasswordremembered"/>
    {!! Form::hidden('id', $item->id) !!}

    <div class="tab-content">
        <div id="client-edit-form-main" class="tab-pane active">
            <div class="form-group">
                <div class="checkbox">
                    {!! Form::checkbox('active', 1, $item->active) !!}
                    {!! Form::label(null, trans('validation.attributes.active')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('email', trans('validation.attributes.email').':') !!}
                {!! Form::text('email', $item->email, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('phone_number', trans('validation.attributes.phone_number').':') !!}
                {!! Form::text('phone_number', $item->phone_number, ['class' => 'form-control']) !!}
            </div>

            <div class="row">
                <div class="col-sm-6">
                    @if ( ! Auth::User()->isManager() || Auth::User()->id != $item->id)
                        @if (Auth::User()->isAdmin())
                            <div class="form-group">
                                {!! Form::label('group_id', trans('validation.attributes.group_id').'*:') !!}
                                {!! Form::select('group_id', ['1' => trans('admin.group_1'), '3' => trans('admin.group_3'), '2' => trans('admin.group_2'), '4' => trans('admin.group_4'), '5' => trans('admin.group_5')], $item->group_id, ['class' => 'form-control', 'data-url' => route('admin.clients.get_permissions_table')]) !!}
                            </div>
                        @else
                            {!! Form::hidden('group_id', 2) !!}
                        @endif
                    @endif
                </div>

                <div class="col-sm-6">
                    @if (Auth::User()->isAdmin())
                        <div class="form-group field_manager_id">
                            {!! Form::label('manager_id', trans('validation.attributes.manager_id').'*:') !!}
                            {!! Form::select('manager_id', $managers, $item->manager_id, ['class' => 'form-control']) !!}
                        </div>
                    @else
                        {!! Form::hidden('manager_id', Auth::User()->id) !!}
                    @endif
                </div>
            </div>

            <div class="form-group">
                {!! Form::label(null, trans('validation.attributes.available_maps').':') !!}
                <div class="checkboxes">
                    {!! Form::hidden('available_maps') !!}
                    @foreach ($maps as $id => $title)
                        <div class="checkbox">
                            {!! Form::checkbox('available_maps[]', $id, in_array($id, $item->available_maps)) !!}
                            {!! Form::label(null, $title) !!}
                        </div>
                    @endforeach
                </div>
            </div>

            @if ( ! Auth::User()->isManager() || Auth::User()->id != $item->id)
                <div class="row">
                    <div class="col-sm-6 no_billing_plan">
                        <div class="form-group">
                            {!! Form::label('devices_limit', trans('validation.attributes.devices_limit').':') !!}

                            <div class="input-group">
                                <div class="checkbox input-group-btn">
                                    {!! Form::checkbox('enable_devices_limit', 1, (!is_null($objects_limit) || !is_null($item->devices_limit)), !is_null($objects_limit) ? ['disabled' => 'disabled'] : []) !!}
                                    {!! Form::label(null, null) !!}
                                </div>
                                {!! Form::text('devices_limit', $item->devices_limit, ['class' => 'form-control']) !!}
                            </div>
                            @if (!is_null($objects_limit))
                                <div class="help-block"> {{ trans('front.maximum_of_objects').': '.$objects_limit }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('expiration_date', trans('validation.attributes.expiration_date').':') !!}

                            <div class="input-group">
                                <div class="checkbox input-group-btn">
                                    {!! Form::checkbox('enable_expiration_date', 1, ($item->subscription_expiration != '0000-00-00 00:00:00')) !!}
                                    {!! Form::label(null, null) !!}
                                </div>
                                {!! Form::text('expiration_date', $item->subscription_expiration == '0000-00-00 00:00:00' ? NULL : $item->subscription_expiration, ['class' => 'form-control datetimepicker']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="form-group">
                <h4>{{ trans('admin.password_change') }}</h4>
            </div>

            <div class="form-group">
                <div class="checkbox-inline">
                    {!! Form::checkbox('password_generate', 1, false) !!}
                    {!! Form::label(null, trans('admin.autogenerate')) !!}
                </div>
                <div class="checkbox-inline">
                    {!! Form::checkbox('password_generate', 0, false, ['data-disabler' => '#password-fields;hide-disable']) !!}
                    {!! Form::label(null, trans('admin.manual')) !!}
                </div>
            </div>
            <div class="row" id="password-fields">
                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('password', trans('validation.attributes.password').':') !!}
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                        {!! error_for('password', $errors) !!}
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('password_confirmation', trans('validation.attributes.password_confirmation').':') !!}
                        {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                        {!! error_for('password_confirmation', $errors) !!}
                    </div>
                </div>
            </div>
        </div>

        <div id="client-edit-form-permissions" class="tab-pane">
            @if ( ! Auth::User()->isManager() || Auth::User()->id != $item->id)
                @if (!empty($plans))
                    <div class="form-group">
                        {!! Form::label('billing_plan_id', trans('front.plan').':') !!}
                        {!! Form::select('billing_plan_id', $plans, $item->billing_plan_id, ['class' => 'form-control', 'data-url' => route('admin.clients.get_permissions_table')]) !!}
                    </div>
                @endif
            @endif
            <div class="user_permissions_ajax">
                @include('Admin.Clients._perms')
            </div>
        </div>

        <div id="client-edit-form-objects" class="tab-pane">
            {!! Form::hidden('objects', null) !!}
            <div class="form-group">
                {!! Form::label('objects', trans('validation.attributes.objects').'*:') !!}
                {!! Form::select('objects[]', $devices, $item->devices->pluck('id', 'id')->all(), ['class' => 'form-control multiexpand', 'multiple' => 'multiple', 'data-live-search' => 'true', 'data-actions-box' => 'true']) !!}
            </div>
        </div>

        @if (settings('plugins.user_api_tab.status'))
            <div id="client-edit-form-api" class="tab-pane">
                <div class="form-group">
                    {!! Form::label(null, trans('front.api_hash') . ':') !!}
                    {!! Form::text(null, $item->api_hash, ['class' => 'form-control', 'readonly' => true]) !!}
                </div>
            </div>
        @endif

        <div id="client-edit-form-listview" class="tab-pane">
            @include('Frontend.ObjectsList.form')
        </div>
        @if ($item->hasCustomFields())
            <div id="user-custom-fields" class="tab-pane">
                @include('Frontend.CustomFields.panel')
            </div>
        @endif
    </div>

    {!! Form::close() !!}
    <script>
        $(document).ready(function() {
            $('#clients_edit').find('input[name="enable_devices_limit"]').trigger('change');
            $('#clients_edit').find('input[name="enable_expiration_date"]').trigger('change');
            $('#clients_edit').find('select[name="billing_plan_id"]').trigger('change');
            checkPerms();
        });
    </script>
@stop