<div class="card">

    <div class="card-image" wire:click="showPhoto('{{$image->id}}','{{$image->id}}')">
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
        <a onclick="swalConfirm('image','{{ $image->asset_id }}','{{$image->id}}')" class="card-footer-item">
            <x-icon icon="delete" fill="{{config('constants.icons.color.danger')}}"/>
        </a>
    </footer>
</div>
