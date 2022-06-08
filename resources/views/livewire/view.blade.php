<div class="section container">

    <script>

        function confirmDelete(assetId,photoId) {
            let msg,cbutton,action,title

            if (assetId && assetId > 0 && photoId && photoId >0) {
                action = 'photo'
                msg = "Selected photo/image will be deleted. You won't be able to revert this!"
                cbutton = 'Delete Image'
                title= 'Delete Image?'
            } else {
                action = 'asset'
                msg = "This action is irreversible. You won't be able to revert this!"
                cbutton = 'Delete Asset'
                title= 'Delete Asset and Attachments?'
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
                    if (action == 'asset') {
                        @this.call('deleteAsset',assetId,photoId)
                    } else {
                        @this.call('deletePhoto',assetId,photoId)
                    }
                }
            })
        }

        function showModal(id) {
            document.getElementById(id).classList.add('is-active')
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('is-active')
        }

        function changeCursor(el,isIn) {
            if (isIn) {
                el.classList.add('finger')
            } else {
                el.classList.remove('finger')
            }
        }

    </script>

    @php
       echo ini_get("upload_max_filesize");
    @endphp

    <!-- Main container -->
    <nav class="level">
        <!-- Left side -->
        <div class="level-left">
            <header class="mt-6">
                <h1 class="title is-size-1 has-text-weight-light">{{ !$asset->is_fake ? 'Asset' : 'Added Files' }}</h1>
                @if (!$asset->is_fake)
                <h1 class="subtitle">{{ $asset->title }}</h1>
                @endif
            </header>
        </div>

        @if (!$asset->is_fake)
        <!-- Right side -->
        <div class="level-right">
            <a href="/assets-form/{{ $asset->id }}" class="button is-link mr-2">Edit</a>
            <button onclick="confirmDelete('{{ $asset->id }}',false)" class="button is-danger is-outlined">Delete</button>
        </div>
        @endif

    </nav>

    @if ($asset->notes)
        <div class="notification">{!! $asset->notes !!}</div>
    @endif

    {{-- IMAGES --}}
    @if ($notification)
        <div class="notification {{$notification["type"]}} is-light">{!! $notification["message"] !!}</div>
    @endif

    @if (count($asset->images) > 0)
    <div class="box">

        <p class="menu-label">IMAGE FILES </p>

        <div class="columns is-multiline">

            @foreach ($asset->images as $image )
            <div class="column is-3-desktop">
                <div class="card">

                    <div class="card-image" wire:click="showPhoto('{{$asset->id}}','{{$image->id}}')">
                        <figure class="image" onmouseover="changeCursor(this,true)" onmouseout="changeCursor(this,false)">
                            <img src="{{ $image->thumbnail }}">
                        </figure>
                    </div>

                    <footer class="card-footer">

                        <a onclick="showModal('m{{$image->id}}')" class="card-footer-item">
                            <x-icon icon="tag" fill="{{config('constants.icons.color.active')}}"/>
                        </a>

                        <a onclick="showModal('m{{$image->id}}')" class="card-footer-item">
                            <x-icon icon="preview" fill="{{config('constants.icons.color.active')}}"/>
                        </a>
                        <a onclick="confirmDelete('{{$asset->id}}','{{$image->id}}')" class="card-footer-item">
                            <x-icon icon="delete" fill="{{config('constants.icons.color.danger')}}"/>
                        </a>
                    </footer>
                </div>
            </div>
            @endforeach

        </div>

    </div>
    @endif




    {{-- VIDEO --}}
    @if (count($asset->video) > 0)
    <div class="box">

        <p class="menu-label">VIDEO FILES </p>

        <div class="columns is-multiline">

            @foreach ($asset->video as $video )
            <div class="column is-3-desktop">
                <div class="card">

                    <div class="card-image" wire:click="showPhoto('{{$asset->id}}','{{$video->id}}')">
                        <figure class="image" onmouseover="changeCursor(this,true)" onmouseout="changeCursor(this,false)">

                            <img src="{{ $video->thumbnail }}">


                        </figure>
                    </div>

                    <footer class="card-footer">

                        <a onclick="showModal('m{{$video->id}}')" class="card-footer-item">
                            <x-icon icon="tag" fill="{{config('constants.icons.color.active')}}"/>
                        </a>

                        <a onclick="showModal('m{{$video->id}}')" class="card-footer-item">
                            <x-icon icon="preview" fill="{{config('constants.icons.color.active')}}"/>
                        </a>
                        <a onclick="confirmDelete('{{$asset->id}}','{{$video->id}}')" class="card-footer-item">
                            <x-icon icon="delete" fill="{{config('constants.icons.color.danger')}}"/>
                        </a>
                    </footer>
                </div>
            </div>
            @endforeach

        </div>

    </div>
    @endif










    {{-- AUDIO  --}}
    @if (count($asset->audio) > 0)
    <div class="box">
        <p class="menu-label">AUDIO/MUSIC FILES </p>
        <ul>
            @foreach ($asset->audio as $audio )
            <li>
                <span class="icon-text">
                <span class="icon">
                    <x-icon icon="attach" fill="{{config('constants.icons.color.dark')}}"/>
                </span>
                <span><a href="/access-audio/{{$audio->id}}">{{$audio->filename}}</a> - {{$audio->size}}</span>
                </span>
            </li>
            @endforeach
        </ul>
    </div>
    @endif


    {{-- DOCS  --}}
    @if (count($asset->docs) > 0)
    <div class="box">
        <p class="menu-label">DOC FILES </p>
        <ul>
            @foreach ($asset->docs as $doc )
            <li>
                <span class="icon-text">
                <span class="icon">
                    <x-icon icon="attach" fill="{{config('constants.icons.color.dark')}}"/>
                </span>
                <span><a href="/access-doc/{{$doc->id}}">{{$doc->filename}}</a> - {{$doc->size}}</span>
                </span>
            </li>
            @endforeach
        </ul>
    </div>
    @endif


    {{--  DATE INFO  --}}
    <nav class="level">
        <!-- Left side -->
        <div class="level-left">
            {{$asset->created_at}}
        </div>

        <!-- Right side -->
        <div class="level-right">
            {{$asset->carbondate}}
        </div>
    </nav>


    {{-- MODALS : IMAGE PROPS --}}
    @foreach ($asset->images as $photo )
        <div class="modal" id="m{{$photo->id}}">
            <div class="modal-background" onclick="closeModal('m{{$photo->id}}')"></div>
            <div class="modal-card">

            <header class="modal-card-head">
                <p class="modal-card-title">{{$photo->filename}}</p>
                <button class="delete" aria-label="close" onclick="closeModal('m{{$photo->id}}')"></button>
            </header>

            <section class="modal-card-body">
                <table class="table is-fullwidth">
                    <tr>
                        <td class="has-text-right has-text-grey">Camera</td>
                        <td>{{$photo->camera ? $photo->camera : 'No data'}}</td>
                    </tr>

                    <tr>
                        <td class="has-text-right has-text-grey">Date Taken</td>
                        <td>{{$photo->datetaken ? $photo->datetaken : 'No data'}}</td>
                    </tr>

                    <tr>
                        <td class="has-text-right has-text-grey">Location</td>
                        <td>
                            @if ($photo->location)

                                <span class="icon-text">
                                    <span class="icon">
                                        <x-icon icon="place" fill="{{config('constants.icons.color.active')}}"/>
                                    </span>
                                    <span>{{$photo->location}}</span>
                                </span>

                            @else
                                <p>No data</p>
                            @endif
                        </td>
                    </tr>
                </table>
            </section>

            </div>
        </div>
    @endforeach

    {{-- IMAGE MODAL --}}
    <div class="modal {{$isImgModalVisible ? 'is-active':''}}" id="img">
        <div class="modal-background" wire:click="closeModal('{{$asset->id}}')"></div>
        <div class="modal-content">
          <p class="image">
            <img src="{{ $photo_data }}">
          </p>
        </div>
        <button class="modal-close is-large" aria-label="close" wire:click="closeModal('{{$asset->id}}')"></button>
    </div>

</div>
