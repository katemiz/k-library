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
                            <p class="title"><a href="/list-records/asset">{{$assets_count}}</a></p>
                        </td>

                        <td class="has-text-centered">
                            <p class="heading">Images</p>
                            <p class="title"><a href="/list-records/image">{{$images_count}}</a></p>
                        </td>

                        <td class="has-text-centered">
                            <p class="heading">Docs</p>
                            <p class="title"><a href="/list-records/doc">{{$docs_count}}</a></p>
                        </td>
                    </tr>

                    <tr>
                        <td class="has-text-centered">
                            <p class="heading">Audio</p>
                            <p class="title"><a href="/list-records/audio">{{$audio_count}}</a></p>
                        </td>

                        <td class="has-text-centered">
                            <p class="heading">Video</p>
                            <p class="title"><a href="/list-records/video">{{$video_count}}</a></p>
                        </td>

                        <td class="has-text-centered">
                            <p class="heading">Others</p>
                            <p class="title"><a href="/list-records/other">{{$others_count}}</a></p>
                        </td>
                    </tr>
                </table>

            </div>

        </div>

    </section>

@endsection
