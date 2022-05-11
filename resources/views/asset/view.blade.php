@extends('layouts.layout')

@section('content')



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
            <a href="/delconfirm/{{ $asset->id }}" class="button is-danger is-outlined">Delete</a>
        </div>
    </nav>





    @if ($asset->notes)
    <div class="notification">{!! $asset->notes !!}</div>
    @endif

    {{-- PHOTOS --}}

    @if (count($asset->photos) > 0)
    <div class="box">

    <p class="menu-label">IMAGE FILES </p>

    <div class="columns is-multiline mt-6">

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
                <a>
                    <x-icon icon="place" fill="{{config('constants.icons.color.active')}}"/>{{$pdf->org_name}}
                </a>
                - {{$pdf->size}}
            </li>
            @endforeach
        </ul>
    </div>
    @endif








@endsection

