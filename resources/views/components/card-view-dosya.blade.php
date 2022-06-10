

@switch($type)
    @case('image')

        @break

    @case('audio')

        @break

    @case('video')

        @break

    @case('document')

        @break


    @case('dosya')

        @break

@endswitch







<tr>
    <td>
        <x-icon icon="attach" fill="{{config('constants.icons.color.dark')}}"/>
    </td>

    <td>
        <a href="/access-{{$type}}/{{$item->id}}">{{$item->filename}}</a> - {{$item->mimetype}} - {{$item->size}}
    </td>
    <td class="has-text-right">
        <a onclick="confirmDelete('{{$type}}','{{ $asset->id }}','{{$item->id}}')">
            <x-icon icon="delete" fill="{{config('constants.icons.color.danger')}}"/>
        </a>
    </td>
</tr>
