<div class="section container">

    <script>

        function confirmDelete(type,id) {
            let msg,cbutton,title

            switch (type) {
                case 'audio':
                    action = 'deleteAudio'
                    msg = "You won't be able to revert this!"
                    cbutton = 'Delete'
                    title= 'Delete Audio?'
                    break;

                case 'docs':
                    action = 'deleteDoc'
                    msg = "You won't be able to revert this!"
                    cbutton = 'Delete'
                    title= 'Delete Doc?'
                    break;

                case 'others':
                    action = 'deleteOthers'
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

            let type = document.getElementById('hiddenType').value
            let query = document.getElementById('queryInput').value

            @this.call('ara',type,query)
        }

        function resetFilter() {
            let type = document.getElementById('hiddenType').value
            document.getElementById('queryInput').value = ''
            @this.call('resetFilter',type)
        }



        function changeCursor(el,isIn) {
            if (isIn) {
                el.classList.add('finger')
            } else {
                el.classList.remove('finger')
            }
        }

    </script>


    <header class="mt-6">

        <h1 class="title is-size-1 has-text-weight-light">
        @switch($type)
            @case('assets')
                My Assets
            @break

            @case('images')
            image
            @break

            @case('video')
            video
            @break

            @case('audio')
            audio
            @break

            @case('docs')
            docs
            @break

            @case('others')
            others
            @break

        @endswitch
        </h1>


    </header>

    @if ($notification)
        <div class="notification {{$notification["type"]}} is-light">{!! $notification["message"] !!}</div>
    @endif


    <nav class="level my-6">

        <!-- Left side -->
        <div class="level-left">
            <div class="level-item  has-text-centered">
                <a href="{{ $type == 'assets' ? '/assets-form' : '/assets-addfiles'}}" class="button is-link">
                    <span class="icon is-small">
                        <x-icon icon="plus" fill="{{config('constants.icons.color.light')}}"/>
                    </span>
                    <span>{{ $type == 'assets' ? 'Add Asset' : 'Add Files'}}</span>
                </a>
            </div>
        </div>

        <!-- Right side -->
        <div class="level-right">

            <div class="level-item">
                <!-- Filter Tree Search Box -->
                <div class="field has-addons is-fullwidth is-pulled-right">

                    <p class="control has-icons-left">
                        <input class="input" type="text" placeholder="Search in my {{$type}} ..." oninput="searchFunction()" id="queryInput">
                        <span class="icon is-small is-left">
                            <x-icon icon="search" fill="{{config('constants.icons.color.disabled')}}"/>
                        </span>
                    </p>
                    <p class="control">
                        <a class="button px-1" onclick="resetFilter()">
                            <x-icon icon="cancel" fill="{{config('constants.icons.color.active')}}"/>
                        </a>
                    </p>
                </div>
            </div>
          </div>

    </nav>

    <div>

        <input type="hidden" id="hiddenType" value="{{$type}}" />

        @switch($type)
            {{-- ASSETS  --}}
            {{-- ------ --}}
            @case('assets')

                @if ($items->total() > 0)

                    <!-- TABLE                    -->
                    <table class="table is-fullwidth">

                        <caption><b>{{ $items->total() }}</b> Result{{ $items->total() > 1 ? 's':'' }}</caption>

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

                            @foreach ($items as $item)
                            <tr>
                                <td>
                                    <a href="/assets-view/{{ $item->id }}">
                                        {{$item->title}}
                                    </a>
                                </td>

                                <td>{!! $item->notes !!}</td>


                                <td>{{$item->created_at}}</td>

                                <td class="has-text-right">

                                    <a href="/assets-view/{{ $item->id }}" class="icon">
                                        <x-icon icon="eye" fill="{{config('constants.icons.color.active')}}"/>
                                    </a>

                                    <a href="/assets-form/{{ $item->id }}" class="icon">
                                        <x-icon icon="edit" fill="{{config('constants.icons.color.active')}}"/>
                                    </a>

                                </td>
                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                @else
                    <div class="notification is-warning is-light">No assets in system yet!</div>
                @endif

                @break

            {{-- PHOTOS  --}}
            {{-- ------ --}}
            @case('images')

                @if ($items->total() > 0)

                    <div class="columns is-multiline">

                        @foreach ($items as $item )
                        <div class="column is-3-desktop">
                            <x-card-image :item="$item"/>
                        </div>
                        @endforeach

                    </div>

                @else
                    <div class="notification is-warning is-light">No photo/image file in system yet!</div>
                @endif

                @break

            {{-- VIDEO  --}}
            {{-- ------ --}}
            @case('video')

                @if ($items->total() > 0)

                    <p class="has-text-centered"><b>{{ $items->total() }}</b> Result{{ $items->total() > 1 ? 's':'' }}</p>

                    <div class="columns mt-3 is-multiline">
                        @foreach ($items as $k => $item)
                        <div class="column is-3-desktop">
                            <x-card-video :item="$item" />
                        </div>
                        @endforeach
                    </div>

                @else
                    <div class="notification is-warning is-light">No video in system yet!</div>
                @endif

                @break




            {{-- AUDIO  --}}
            {{-- ------ --}}
            @case('audio')

                @if ($items->total() > 0)

                    <!-- TABLE                    -->
                    <table class="table is-fullwidth">

                        <caption><b>{{ $items->total() }}</b> Result{{ $items->total() > 1 ? 's':'' }}</caption>

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

                            @foreach ($items as $item)
                            <tr>
                                <td>
                                    <a href="/assets-view/{{ $item->id }}">{{$item->org_name}}</a>
                                </td>

                                <td>{{$item->created_at}}</td>

                                <td class="has-text-right">

                                    <a href="/assets-view/{{ $item->id }}" class="icon">
                                        <x-icon icon="edit" fill="{{config('constants.icons.color.active')}}"/>
                                    </a>

                                    <a onclick="confirmDelete('{{ $type }}','{{ $item->id }}')" class="icon">
                                        <x-icon icon="delete" fill="{{config('constants.icons.color.danger')}}"/>
                                    </a>

                                </td>
                            </tr>
                            @endforeach

                        </tbody>

                    </table>

                @else
                    <div class="notification is-warning is-light">No audio/music in system yet!</div>
                @endif

                @break

            {{-- DOCS  --}}
            {{-- ------ --}}
            @case('docs')

                @if ($items->total() > 0)

                    <!-- TABLE                    -->
                    <table class="table is-fullwidth">

                        <caption><b>{{ $items->total() }}</b> Result{{ $items->total() > 1 ? 's':'' }}</caption>

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

                            @foreach ($items as $item)
                            <tr>
                                <td>
                                    <a href="/assets-view/{{ $item->id }}">
                                        {{$item->org_name}}
                                    </a>
                                </td>

                                <td>{{$item->created_at}}</td>

                                <td class="has-text-right">

                                    <a href="/assets-view/{{ $item->id }}" class="icon">
                                        <x-icon icon="eye" fill="{{config('constants.icons.color.active')}}"/>
                                    </a>

                                    <a onclick="confirmDelete('{{ $type }}','{{ $item->id }}')" class="icon">
                                        <x-icon icon="delete" fill="{{config('constants.icons.color.danger')}}"/>
                                    </a>

                                </td>
                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                @else
                    <div class="notification is-warning is-light">No pdf files in system yet!</div>
                @endif

                @break


            {{-- OTHER  --}}
            {{-- ------ --}}
            @case('others')

                @if ($items->total() > 0)

                <!-- TABLE                    -->
                <table class="table is-fullwidth">

                    <caption><b>{{ $items->total() }}</b> Result{{ $items->total() > 1 ? 's':'' }}</caption>

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

                        @foreach ($items as $item)
                        <tr>
                            <td>
                                <a href="/assets-view/{{ $item->id }}">
                                    {{$item->org_name}}
                                </a>
                            </td>

                            <td>{{$item->created_at}}</td>

                            <td class="has-text-right">

                                <a href="/assets-view/{{ $item->id }}" class="icon">
                                    <x-icon icon="eye" fill="{{config('constants.icons.color.active')}}"/>
                                </a>

                                <a onclick="confirmDelete('{{ $type }}','{{ $item->id }}')" class="icon">
                                    <x-icon icon="delete" fill="{{config('constants.icons.color.danger')}}"/>
                                </a>
                            </td>
                        </tr>

                        @endforeach

                    </tbody>

                </table>

                @else
                    <div class="notification is-warning is-light">No uncategorized file in system yet!</div>
                @endif

                @break

        @endswitch

        {{ $items->links() }}

    </div>

</div>
