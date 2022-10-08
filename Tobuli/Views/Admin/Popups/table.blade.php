<div class="table_error"></div>
<div class="table-responsive">
    <table class="table table-list" data-toggle="multiCheckbox">
        <thead>
        <tr>
            {!! tableHeaderCheckall(['delete_url' => trans('admin.delete_selected')]) !!}
            {!! tableHeader('validation.attributes.title') !!}
            {!! tableHeader('validation.attributes.position') !!}
            {!! tableHeader('validation.attributes.active') !!}
            {!! tableHeader('admin.actions', 'style="text-align: right;"') !!}
        </tr>
        </thead>

        <tbody>
        @if (count($collection = $items->getCollection()))
            @foreach ($collection as $item)
                <tr>
                    <td>
                        <div class="checkbox">
                            <input type="checkbox" value="{!! $item->id !!}">
                            <label></label>
                        </div>
                    </td>
                    <td>
                        {!! $item->title !!}
                    </td>
                    <td>
                        {!! $item->position !!}
                    </td>
                    <td>
                        <span class="label label-sm label-{!! $item->active ? 'success' : 'danger' !!}">
                            {!! $item->active ? trans('validation.attributes.active') :trans('front.off') !!}
                        </span>
                    </td>
                    <td class="actions">
                        <div class="btn-group dropdown droparrow" data-position="fixed">
                            <i class="btn icon edit" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"></i>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:" data-modal="{!! $section !!}_edit" data-url="{!! route("admin.{$section}.edit", $item->id) !!}">{!! trans('global.edit') !!}</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>

            @endforeach
        @else
            <tr class="">
                <td class="no-data" colspan="13">
                    {!! trans('admin.no_data') !!}
                </td>
            </tr>
        @endif
        </tbody>
    </table>
</div>

{{--@include("Admin.Layouts.partials.pagination")--}}