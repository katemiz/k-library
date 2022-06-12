<div class="section container">

    <script src="{{ asset('/js/delete.js') }}"></script>
    <script src="{{ asset('/js/modal.js') }}"></script>
    <script src="{{ asset('/js/cursor.js') }}"></script>

    <!-- Main container -->
    <nav class="level">
        <!-- Left side -->
        <div class="level-left">
            <header class="mt-6">
                <h1 class="title is-size-1 has-text-weight-light">{{ !$asset->is_fake ? 'Asset' : 'Added Files' }}</h1>
                <h1 class="subtitle">{{ !$asset->is_fake ? $asset->title : 'Not an asset'}}</h1>
            </header>
        </div>

        <!-- Right side -->
        <div class="level-right">
            @if (!$asset->is_fake)
            <a href="/assets-form/{{ $asset->id }}" class="button is-link mr-2">Edit</a>
            @endif
            <button onclick="swalConfirm('asset','{{ $asset->id }}',false)" class="button is-danger is-outlined">Delete</button>
        </div>
    </nav>

    @if ($asset->notes)
        <div class="notification">{!! $asset->notes !!}</div>
    @endif

    {{-- NOTIFICATION --}}
    @if ($notification)
        <div class="notification {{$notification["type"]}} is-light">{!! $notification["message"] !!}</div>
    @endif

    {{-- IMAGES --}}
    @if (count($asset->images) > 0)
    <div class="box">
        <p class="menu-label">IMAGE FILES </p>
        <div class="columns is-multiline">
            @foreach ($asset->images as $image )
            <div class="column is-3-desktop">
                <x-card-image :image="$image" />
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
                <x-card-video :video="$video" />
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- AUDIO  --}}
    @if (count($asset->audio) > 0)
    <div class="box">
        <p class="menu-label">AUDIO FILES </p>
        <table class="table is-fullwidth">
            @foreach ($asset->audio as $audio )
                <x-card-view-dosya type="audio" :item="$audio" :asset="$asset"/>
            @endforeach
        </table>
    </div>
    @endif

    {{-- DOCS  --}}
    @if (count($asset->docs) > 0)
    <div class="box">
        <p class="menu-label">DOC FILES </p>
        <table class="table is-fullwidth">
            @foreach ($asset->docs as $doc )
                <x-card-view-dosya type="document" :item="$doc" :asset="$asset"/>
            @endforeach
        </table>
    </div>
    @endif

    {{-- OTHER TYPES  --}}
    @if (count($asset->dosyalar) > 0)
    <div class="box">
        <p class="menu-label">OTHER FILE TYPES </p>
        <table class="table is-fullwidth">
            @foreach ($asset->dosyalar as $dosya )
                <x-card-view-dosya type="dosya" :item="$dosya" :asset="$asset"/>
            @endforeach
        </table>
    </div>
    @endif

    {{--  DATE INFO  --}}
    <x-card-date :item="$asset" />

    {{-- IMAGE MODAL --}}
    <div class="modal {{$isImgModalVisible ? 'is-active':''}}" id="img">
        <div class="modal-background" wire:click="closeModal('{{$asset->id}}')"></div>
        <div class="modal-content">
          <p class="image">
            <img src="{{ $img_modal_data }}">
          </p>
        </div>
        <button class="modal-close is-large" aria-label="close" wire:click="closeModal('{{$asset->id}}')"></button>
    </div>

</div>
