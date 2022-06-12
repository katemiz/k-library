<div class="card">

    <div class="card-image" wire:click="imageModal('{{$image->asset_id}}','{{$image->id}}')">
        <figure class="image" onmouseover="changeCursor(this,true)" onmouseout="changeCursor(this,false)">
            <img src="{{ $image->thumbnail }}">
        </figure>
    </div>

    <footer class="card-footer">
        <a onclick="showModal('Modal{{$image->id}}')" class="card-footer-item">
            <x-icon icon="tag" fill="{{config('constants.icons.color.active')}}"/>
        </a>

        <a onclick="showModal('Modal{{$image->id}}')" class="card-footer-item">
            <x-icon icon="preview" fill="{{config('constants.icons.color.active')}}"/>
        </a>
        <a onclick="swalConfirm('image','{{ $image->asset_id }}','{{$image->id}}')" class="card-footer-item">
            <x-icon icon="delete" fill="{{config('constants.icons.color.danger')}}"/>
        </a>
    </footer>
</div>



<div class="modal" id="Modal{{$image->id}}">
    <div class="modal-background" onclick="closeModal('Modal{{$image->id}}')"></div>
    <div class="modal-card">

    <header class="modal-card-head">
        <p class="modal-card-title">{{$image->filename}}</p>
        <button class="delete" aria-label="close" onclick="closeModal('Modal{{$image->id}}')"></button>
    </header>

    <section class="modal-card-body">
        <table class="table is-fullwidth">
            <tr>
                <td class="has-text-right has-text-grey">Camera</td>
                <td>{{$image->camera ? $image->camera : 'No data'}}</td>
            </tr>

            <tr>
                <td class="has-text-right has-text-grey">Date Taken</td>
                <td>{{$image->datetaken ? $image->datetaken : 'No data'}}</td>
            </tr>

            <tr>
                <td class="has-text-right has-text-grey">Location</td>
                <td>
                    @if ($image->location)

                        <span class="icon-text">
                            <span class="icon">
                                <x-icon icon="place" fill="{{config('constants.icons.color.active')}}"/>
                            </span>
                            <span>{{$image->location}}</span>
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
