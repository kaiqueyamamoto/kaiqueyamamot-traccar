<table class="table table-list table-hover">
    <tbody>
    @if (!empty($chattableObjects))
        @foreach ($chattableObjects as $key => $item)
            <tr >
                <td>
                    <a href="javascript:" class="pointer" onclick="app.chat.openChatModal('{{ route('chat.init', $item['id']) }}');">
                        <div class="name">
                            <span >{{ $item['name'] }}</span>
                        </div>
                    </a>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td class="no-data">{!!trans('front.no_devices')!!}</td>
        </tr>
    @endif
    </tbody>
</table>

@if (!empty($chattableObjects))
    <div class="nav-pagination">
        {!! $chattableObjects->setPath(route('chat.searchParticipant'))->render() !!}
    </div>
@endif