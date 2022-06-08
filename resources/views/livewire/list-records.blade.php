<div class="section container">

    <script>

        function confirmDelete(type,id) {
            let msg,cbutton,title

            switch (type) {
                case 'asset':
                    action = 'deleteAsset'
                    msg = "You won't be able to revert this!"
                    cbutton = 'Delete'
                    title= 'Delete Asset?'
                    break;

                case 'image':
                    action = 'deleteRecord'
                    msg = "You won't be able to revert this!"
                    cbutton = 'Delete'
                    title= 'Delete Image?'
                    break;


                case 'audio':
                    action = 'deleteRecord'
                    msg = "You won't be able to revert this!"
                    cbutton = 'Delete'
                    title= 'Delete Audio?'
                    break;

                case 'doc':
                    action = 'deleteRecord'
                    msg = "You won't be able to revert this!"
                    cbutton = 'Delete'
                    title= 'Delete Doc?'
                    break;

                case 'other':
                    action = 'deleteRecord'
                    msg = "You won't be able to revert this!"
                    cbutton = 'Delete'
                    title= 'Delete File?'
                    break;

                default:
                    break;
            }

            Swal.fire({
                title: title,
                text: msg,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: cbutton
            }).then((result) => {

                if (result.isConfirmed) {
                    @this.call(action,id)
                }
            })
        }


        function searchFunction() {

            if (document.getElementById('queryInput').value.length > 1) {
                @this.call('ara',document.getElementById('queryInput').value)
            }

            return true
        }

        function resetFilter() {
            let type = document.getElementById('hiddenType').value
            document.getElementById('queryInput').value = ''
            @this.call('resetFilter',type)
        }

    </script>

    <header class="mb-6">

        <h1 class="title is-size-1 has-text-weight-light">
        @switch($type)
            @case('asset')
                My Assets
                @break

            @case('image')
                image
                @break

            @case('video')
                video
                @break

            @case('audio')
                audio
                @break

            @case('doc')
                docs
                @break

            @case('other')
                others
                @break

        @endswitch
        </h1>

    </header>

    <input type="hidden" id="hiddenType" value="{{$type}}" />

    <x-table-filter type="{{$type}}" />

    @if ($records->total() > 0)




        @switch($type)

            {{-- ASSET --}}
            {{-- --------------------------- --}}
            @case('asset')

                <table class="table is-fullwidth">

                    <caption><b>{{ $records->total() }}</b> Result{{ $records->total() > 1 ? 's':'' }}</caption>

                    <thead>
                    <tr>

                        <th>
                            <span class="icon-text" wire:click="sortBy('title')">
                                <span class="icon {{ $sortDirection === 'asc' ? 'is-hidden' : ''}}">
                                    <x-icon icon="arrow-up" fill="{{config('constants.icons.color.active')}}"/>
                                </span>
                                <span class="icon {{ $sortDirection === 'desc' ? 'is-hidden' : ''}}">
                                    <x-icon icon="arrow-down" fill="{{config('constants.icons.color.active')}}"/>
                                </span>
                                <span>Title</span>
                            </span>
                        </th>

                        <th class="is-2">Notes/Remarks</th>

                        <th class="is-2">
                            <span class="icon-text" wire:click="sortBy('created_at')">
                                <span class="icon {{ $sortTimeDirection === 'asc' ? 'is-hidden' : ''}}">
                                    <x-icon icon="arrow-up" fill="{{config('constants.icons.color.active')}}"/>
                                </span>
                                <span class="icon {{ $sortTimeDirection === 'desc' ? 'is-hidden' : ''}}">
                                    <x-icon icon="arrow-down" fill="{{config('constants.icons.color.active')}}"/>
                                </span>
                                <span>Created At</span>
                            </span>
                        </th>

                        <th class="has-text-right is-2">Actions</th>
                    </tr>
                    </thead>

                    <tbody>

                        @foreach ($records as $record)
                        <tr>
                            <td>
                                <a href="/assets-view/{{ $record->id }}">{{$record->title}}</a>
                            </td>

                            <td>{!! $record->notes !!}</td>
                            <td>{{$record->created_at}}</td>

                            <td class="has-text-right">

                                <a href="/assets-view/{{ $record->id }}" class="icon">
                                    <x-icon icon="eye" fill="{{config('constants.icons.color.active')}}"/>
                                </a>

                                <a href="/assets-form/{{ $record->id }}" class="icon">
                                    <x-icon icon="edit" fill="{{config('constants.icons.color.active')}}"/>
                                </a>

                            </td>
                        </tr>
                        @endforeach

                    </tbody>

                </table>

                @break


            {{-- IMAGE --}}
            {{-- --------------------------- --}}
            @case('image')

                {{ $records->links()}}

                <caption><b>{{ $records->total() }}</b> Result{{ $records->total() > 1 ? 's':'' }}</caption>

                <div class="columns is-multiline">
                    @foreach ($records as $record)

                        <div class="column is-3-desktop">
                            <x-card-image :item="$record" />
                        </div>

                    @endforeach
                </div>
                @break



            {{-- VIDEO --}}
            {{-- --------------------------- --}}
            @case('video')

                <caption><b>{{ $records->total() }}</b> Result{{ $records->total() > 1 ? 's':'' }}</caption>

                <div class="columns is-multiline">
                    @foreach ($records as $record)

                        <div class="column is-3-desktop">
                            <x-card-video :item="$record" />
                        </div>

                    @endforeach
                </div>
                @break

            {{-- DEFAULT --}}
            {{-- --------------------------- --}}
            @case('audio')
            @case('doc')
            @case('other')

            @default

                <!-- TABLE -->
                <table class="table is-fullwidth">

                    <caption><b>{{ $records->total() }}</b> Result{{ $records->total() > 1 ? 's':'' }}</caption>

                    <thead>
                    <tr>

                        <th>
                            <span class="icon-text" wire:click="sortBy('title')">
                                <span class="icon {{ $sortDirection === 'asc' ? 'is-hidden' : ''}}">
                                    <x-icon icon="arrow-up" fill="{{config('constants.icons.color.active')}}"/>
                                </span>
                                <span class="icon {{ $sortDirection === 'desc' ? 'is-hidden' : ''}}">
                                    <x-icon icon="arrow-down" fill="{{config('constants.icons.color.active')}}"/>
                                </span>
                                <span>Filename - Title</span>
                            </span>
                        </th>

                        <th class="is-2">
                            <span class="icon-text" wire:click="sortBy('created_at')">
                                <span class="icon {{ $sortTimeDirection === 'asc' ? 'is-hidden' : ''}}">
                                    <x-icon icon="arrow-up" fill="{{config('constants.icons.color.active')}}"/>
                                </span>
                                <span class="icon {{ $sortTimeDirection === 'desc' ? 'is-hidden' : ''}}">
                                    <x-icon icon="arrow-down" fill="{{config('constants.icons.color.active')}}"/>
                                </span>
                                <span>Created At</span>
                            </span>
                        </th>

                        <th class="has-text-right is-2">Actions</th>
                    </tr>
                    </thead>

                    <tbody>

                        @foreach ($records as $record)
                        <tr>

                            <td>
                                <a href="/assets-view/{{ $record->id }}">{{$record->filename}}</a>
                            </td>

                            <td>{{$record->created_at}}</td>

                            <td class="has-text-right">

                                <a href="/assets-view/{{ $record->id }}" class="icon">
                                    <x-icon icon="edit" fill="{{config('constants.icons.color.active')}}"/>
                                </a>

                                <a onclick="confirmDelete('{{ $type }}','{{ $record->id }}')" class="icon">
                                    <x-icon icon="delete" fill="{{config('constants.icons.color.danger')}}"/>
                                </a>

                            </td>

                        </tr>
                        @endforeach

                    </tbody>

                </table>


                @break

        @endswitch








        {{ $records->links()}}

    @else
        <div class="notification is-warning is-light">No record [{{$type}}] in system yet!</div>
    @endif

</div>
