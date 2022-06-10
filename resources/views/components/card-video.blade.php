

<div class="card">

    <div class="card-image" wire:click="showPhoto('{{$item->id}}','{{$item->id}}')">
        <figure class="image is-16by9" onmouseover="changeCursor(this,true)" onmouseout="changeCursor(this,false)">
            <img src="{{ $item->thumbnail }}">
        </figure>
    </div>

    <footer class="card-footer">

        <p class="card-footer-item">
            {{$item->mimetype}}
        </p>
        <a onclick="confirmDelete('{{$item->id}}','{{$item->id}}')" class="card-footer-item">
            <x-icon icon="delete" fill="{{config('constants.icons.color.danger')}}"/>
        </a>
    </footer>
</div>
