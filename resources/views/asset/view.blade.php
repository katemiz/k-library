@extends('layouts.layout')

@section('content')

    <header class="mt-6">
      <h1 class="title is-size-1 has-text-weight-light">Asset</h1>
      <h1 class="subtitle">{{ $asset->title }}</h1>
    </header>

    @if ($asset->notes)
    <div class="notification">{!! $asset->notes !!}</div>
    @endif

    {{-- PHOTOS --}}
    <div class="columns is-multiline mt-6">

        @if (count($asset->photos) > 0)
            @foreach ($asset->photos as $photo )
            <div class="column is-3-desktop">
                <div class="card">

                    <header class="card-header">
                        <p class="card-header-title heading has-text-centered">
                            {{$photo->has_exif ? $photo->camera : 'No Camera'}} - {{$photo->mimetype}}
                        </p>
                    </header>

                    <div class="card-image">
                        <figure class="image ">
                            <img src="{{ $asset->dosyalar[$photo->id] }}">
                        </figure>
                    </div>

                    <div class="content">
                        <p class="heading has-text-centered">{{$photo->has_exif ? $photo->datetaken : 'No Date'}}</p>
                    </div>

                    <footer class="card-footer">

                        @if ($photo->location)
                        <a href="#" class="card-footer-item" data-loc="{{$photo->location}}">
                            <x-icon icon="place" fill="{{config('constants.icons.color.active')}}"/>
                        </a>
                        @endif
                        <a href="#" class="card-footer-item">
                            <x-icon icon="edit" fill="{{config('constants.icons.color.active')}}"/>
                        </a>
                        <a href="#" class="card-footer-item">
                            <x-icon icon="delete" fill="{{config('constants.icons.color.danger')}}"/>
                        </a>
                    </footer>
                </div>
            </div>
            @endforeach
        @else

            <div class="notification is-warning is-light">
                No files for this asset yet!
            </div>

        @endif

    </div>

    {{-- PDFS  --}}
    <div class="box">
        <aside class="menu">

        @if (count($asset->pdfs) > 0)
            <p class="menu-label">PDF FILES </p>
            <ul class="menu-list">
                @foreach ($asset->pdfs as $pdf )
                    <li><a>{{$pdf->org_name}} - {{$pdf->size}}</a></li>
                @endforeach
            </ul>
        @endif
        </aside>
    </div>

@endsection

