<div class="card">

    <div class="card-image" wire:click="showPhoto('{{$video->id}}','{{$video->id}}')">
        <figure class="image is-16by9" onmouseover="changeCursor(this,true)" onmouseout="changeCursor(this,false)">
            <img src="{{ $video->thumbnail }}">
        </figure>
    </div>

    <footer class="card-footer">

        <p class="card-footer-item">
            {{$video->mimetype}}
        </p>
        <a onclick="swalConfirm('video','{{$video->asset_id}}','{{$video->id}}')" class="card-footer-item">
            <x-icon icon="delete" fill="{{config('constants.icons.color.danger')}}"/>
        </a>
    </footer>
</div>
