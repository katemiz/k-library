@extends('layouts.layout')

@section('content')

    <section class="section container">

        <header class="my-6">
            <h1 class="title has-text-weight-light is-size-1">{{config('constants.app.welcome_header')}}</h1>
            <h2 class="subtitle has-text-weight-light">{{config('constants.app.welcome_subtitle')}}</h2>
        </header>

        <div class="columns">

            <div class="column is-quarter">
                <figure class="image is-4by3">
                    <img alt="library" class="hero-background" src="images/stats.svg">
                </figure>
            </div>

            <div class="column">

                <table class="table is-fullwidth">
                    <tr>
                        <td class="has-text-centered">
                            <p class="heading">Assets</p>
                            <p class="title"><a href="/assets-list/assets">{{$asset_count}}</a></p>
                        </td>

                        <td class="has-text-centered">
                            <p class="heading">Photo</p>
                            <p class="title"><a href="/assets-list/photos">{{$photo_count}}</a></p>
                        </td>

                        <td class="has-text-centered">
                            <p class="heading">Pdf</p>
                            <p class="title"><a href="/assets-list/pfs">{{$pdf_count}}</a></p>
                        </td>
                    </tr>

                    <tr>
                        <td class="has-text-centered">
                            <p class="heading">Music</p>
                            <p class="title"><a href="/assets-list/music">{{$music_count}}</a></p>
                        </td>

                        <td class="has-text-centered">
                            <p class="heading">Video</p>
                            <p class="title"><a href="/assets-list/video">{{$video_count}}</a></p>
                        </td>

                        <td class="has-text-centered">
                            <p class="heading">Other</p>
                            <p class="title"><a href="/assets-list/other">{{$other_count}}</a></p>
                        </td>
                    </tr>
                </table>

            </div>

        </div>

    </section>

@endsection
