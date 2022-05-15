<div class="section container">

    <script>

        function confirmDelete(assetId,photoId) {

            let msg,cbutton,action

            if (assetId && photoId) {
                action = 'asset'
                msg = "Selected photo/image will be deleted. You won't be able to revert this!"
                cbutton = 'Delete Image'
            } else {
                action = 'photo'
                msg = "This action is irreversible. You won't be able to revert this!"
                cbutton = 'Delete Asset'
            }

            Swal.fire({
                title: 'Are you sure?',
                text: msg,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: cbutton
            }).then((result) => {

                console.log(result)
                if (result.isConfirmed) {

                    if (action == 'action') {
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

    <!-- Main container -->
    <nav class="level">
        <!-- Left side -->
        <div class="level-left">
            <header class="mt-6">
                <h1 class="title is-size-1 has-text-weight-light">Asset</h1>
                <h1 class="subtitle">{{ $asset->title }}</h1>
            </header>
        </div>

        <!-- Right side -->
        <div class="level-right">
            <a href="/assets-form/{{ $asset->id }}" class="button is-link mr-2">Edit</a>
            <button onclick="confirmDelete('{{ $asset->id }}',false)" class="button is-danger is-outlined">Delete</button>
        </div>
    </nav>

    @if ($asset->notes)
        <div class="notification">{!! $asset->notes !!}</div>
    @endif

    {{-- PHOTOS --}}
    @if (count($asset->photos) > 0)
    <div class="box">

        @if ($notification)
        <div class="notification {{$notification["type"]}} is-light">{!! $notification["message"] !!}</div>
        @endif

        <p class="menu-label">IMAGE FILES </p>

        <div class="columns is-multiline">

            @foreach ($asset->photos as $photo )
            <div class="column is-3-desktop">
                <div class="card">

                    <div class="card-image" wire:click="showPhoto('{{$asset->id}}','{{$photo->id}}')">
                        <figure class="image" onmouseover="changeCursor(this,true)" onmouseout="changeCursor(this,false)">
                            <img src="{{ $asset->dosyalar[$photo->id] }}">
                        </figure>
                    </div>

                    <footer class="card-footer">

                        <a onclick="showModal('m{{$photo->id}}')" class="card-footer-item">
                            <x-icon icon="tag" fill="{{config('constants.icons.color.active')}}"/>
                        </a>

                        <a onclick="showModal('m{{$photo->id}}')" class="card-footer-item">
                            <x-icon icon="preview" fill="{{config('constants.icons.color.active')}}"/>
                        </a>
                        <a onclick="confirmDelete('{{$asset->id}}','{{$photo->id}}')" class="card-footer-item">
                            <x-icon icon="delete" fill="{{config('constants.icons.color.danger')}}"/>
                        </a>
                    </footer>
                </div>
            </div>
            @endforeach

        </div>

    </div>
    @endif

    {{-- PDFS  --}}
    @if (count($asset->pdfs) > 0)
    <div class="box">
        <p class="menu-label">PDF FILES </p>
        <ul>
            @foreach ($asset->pdfs as $pdf )
            <li>
                <span class="icon-text">
                <span class="icon">
                    <x-icon icon="attach" fill="{{config('constants.icons.color.dark')}}"/>
                </span>
                <span><a href="/view-pdf/{{$pdf->id}}">{{$pdf->org_name}}</a> - {{$pdf->size}}</span>
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
    @foreach ($asset->photos as $photo )
        <div class="modal" id="m{{$photo->id}}">
            <div class="modal-background" onclick="closeModal('m{{$photo->id}}')"></div>
            <div class="modal-card">

            <header class="modal-card-head">
                <p class="modal-card-title">{{$photo->org_name}}</p>
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
