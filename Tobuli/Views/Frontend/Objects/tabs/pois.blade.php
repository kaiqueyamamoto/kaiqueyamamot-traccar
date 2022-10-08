<div class="tab-pane" id="pois_tab">
    <div class="tab-pane-header">
        <div class="form">
            <div class="input-group">
                <div class="form-group search">
                    {!!Form::text('search', null, ['class' => 'form-control', 'placeholder' => trans('front.search'), 'autocomplete' => 'off'])!!}
                </div>
                @if (Auth::User()->perm('poi', 'edit'))
                <span class="input-group-btn">
                    <button class="btn btn-default" title="{{ trans('front.import') }}" data-url="{{ route('pois.import') }}" data-modal="pois_import">
                        <i class="icon upload"></i>
                    </button>

                    <a href="javascript:" class="btn btn-primary" type="button" onClick="app.pois.create();">
                        <i class="icon add"></i>
                    </a>
                </span>
                @endif
            </div>
        </div>
    </div>

    <div class="tab-pane-body">
        <div id="ajax-map-icons"></div>
    </div>
</div>

<div class="tab-pane" id="pois_create">
    {!!Form::open(['route' => 'pois.store', 'method' => 'POST', 'id' => 'poi_create'])!!}
    <div class="tab-pane-header">
        <div class="alert alert-info">
            {!!trans('front.please_click_on_map')!!}
        </div>
        {!!Form::hidden('id')!!}
        {!!Form::hidden('coordinates')!!}
        <div class="form-group">
            {!!Form::label('name', trans('validation.attributes.name').':')!!}
            {!!Form::text('name', null, ['class' => 'form-control'])!!}
        </div>
        <div class="form-group">
            {!!Form::label('description', trans('validation.attributes.description').':')!!}
            {!!Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3])!!}
        </div>
        <div class="form-group">
            {!! Form::label('group_id', trans('validation.attributes.group_id').':') !!}
            {!! Form::select('group_id', $poi_groups, null, ['class' => 'form-control']) !!}
        </div>

        {!!Form::label('map_icon_idd', trans('validation.attributes.map_icon_id').':')!!}
        {!!Form::hidden('map_icon_id')!!}
    </div>
    <div class="tab-pane-body">
        <div class="icon-list">
        @foreach($mapIcons->toArray() as $key=>$value)
            <div class="checkbox-inline">
                {!!Form::radio('map_icon_id', $value['id'], null, ['data-width' => $value['width'], 'data-height' => $value['height']])!!}
                <label><img src="{!!asset($value['path'])!!}" alt="ICON"></label>
            </div>
        @endforeach
        </div>
    </div>
    <div class="tab-pane-footer">
        <div class="buttons text-center">
            <a type="button" class="btn btn-action" href="javascript:" onClick="app.pois.store();">{!!trans('global.save')!!}</a>
            <a type="button" class="btn btn-default" href="javascript:" onClick="app.openTab('pois_tab');">{!!trans('global.cancel')!!}</a>
        </div>
    </div>
    {!!Form::close()!!}
</div>

<div class="tab-pane" id="pois_edit">
    {!!Form::open(['route' => 'pois.update', 'method' => 'PUT', 'id' => 'poi_update'])!!}
    <div class="tab-pane-header">
        {!!Form::hidden('id')!!}
        {!!Form::hidden('coordinates')!!}
        <div class="form-group">
            {!!Form::label('name', trans('validation.attributes.name').':')!!}
            {!!Form::text('name', null, ['class' => 'form-control'])!!}
        </div>
        <div class="form-group">
            {!!Form::label('description', trans('validation.attributes.description').':')!!}
            {!!Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3])!!}
        </div>
        <div class="form-group">
            {!! Form::label('group_id', trans('validation.attributes.group_id').':') !!}
            {!! Form::select('group_id', $poi_groups, null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!!Form::label('map_icon_idd', trans('validation.attributes.map_icon_id').':')!!}
            {!!Form::hidden('map_icon_id')!!}
        </div>
    </div>

    <div class="tab-pane-body">
        <div class="icon-list">
            @foreach($mapIcons->toArray() as $key=>$value)
                <div class="checkbox-inline">
                    {!!Form::radio('map_icon_id', $value['id'], null, ['data-width' => $value['width'], 'data-height' => $value['height']])!!}
                    <label><img src="{!!asset($value['path'])!!}" alt="ICON"></label>
                </div>
            @endforeach
        </div>
    </div>
    <div class="tab-pane-footer">
        <div class="buttons text-center">
            <a type="button" class="btn btn-action" href="javascript:" onClick="app.pois.update();">{!!trans('global.save')!!}</a>
            <a type="button" class="btn btn-default" href="javascript:" onClick="app.openTab('pois_tab');">{!!trans('global.cancel')!!}</a>
        </div>
    </div>
    {!!Form::close()!!}
</div>