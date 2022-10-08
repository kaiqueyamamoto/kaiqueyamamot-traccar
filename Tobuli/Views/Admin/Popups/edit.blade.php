@extends('Frontend.Layouts.modal')

@section('title')
    <i class="icon event"></i> {{ trans('global.edit') }}
@stop

@section('body')

    {!!Form::open(['route' => 'admin.popups.update', 'method' => 'PUT'])!!}
    {!!Form::hidden('id', $item->id)!!}

    <div class="form-group">
        <div class="checkbox">
            {!!Form::checkbox('active', 1, ($item->active ? 1 : 0))!!}
            {!!Form::label('active', trans('validation.attributes.active'))!!}
        </div>
    </div>

    <div class="form-group">
        {!!Form::label('position', trans('validation.attributes.position').':')!!}
        {!!Form::select('position', $positions, $item->position, ['class' => 'form-control'])!!}
    </div>

    <div class="form-group">
        {!!Form::label('title', trans('validation.attributes.title').':')!!}
        {!!Form::text('title', $item->title, ['class' => 'form-control'])!!}
    </div>

    <div class="form-group">
        {!!Form::label('content', trans('admin.content').':')!!}
        {!!Form::textarea('content', $item->content, ['class' => 'form-control'])!!}
        <span>{{trans('admin.shortcodes')}}: @foreach($item->getPossibleShortcodes() as $shortcode) {{$shortcode}} @endforeach </span>
    </div>

    <div class="form-group">
        {!!Form::label('show_every_days', trans('admin.show_every_days').':')!!}
        {!!Form::text('show_every_days', $item->show_every_days, ['class' => 'form-control'])!!}
    </div>

    <div class="form-group">
        {!!Form::label('conditions', trans('front.conditions').':')!!}

        {!! $item->getForm() !!}
    </div>

    {!! Form::close() !!}
@stop