<tr>
    <td>
        <x-icon icon="attach" fill="{{config('constants.icons.color.dark')}}"/>
    </td>

    <td>
        <a href="/access-{{$type}}/{{$item->id}}">{{$item->filename}}</a> - {{$item->mimetype}} - {{$item->size}}
    </td>
    <td class="has-text-right">
        <a onclick="swalConfirm('{{$type}}','{{ $asset->id }}','{{$item->id}}')">
            <x-icon icon="delete" fill="{{config('constants.icons.color.danger')}}"/>
        </a>
    </td>
</tr>
