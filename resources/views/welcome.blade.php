@extends('layouts.layout')


@section('content')

    <section class="hero is-medium ">

        <figure class="image is-16by9">
            <img alt="library" class="hero-background" src="images/library.svg">
        </figure>

    </section>


    <section class="section container">

        <header class="my-6">
            <h1 class="title has-text-weight-light is-size-1">{{config('constants.app.welcome_header')}}</h1>
            <h2 class="subtitle has-text-weight-light">{{config('constants.app.welcome_subtitle')}}</h2>
        </header>


        <p class="mb-3">
            <a href="https://github.com/katemiz/k-library">{{config('constants.app.name')}}</a>, "{{config('constants.app.title')}}" is an app designed to keep your digital assets in one place and accessible <strong>only for you</strong>. Wherever your are, whenever you need your digital assets, theyare available for you only.
        </p>

        <p class="mb-3">
            This app is suitable to deploy and run your own server. You only need a dedicated server (<a href="https://www.raspberrypi.org/">Raspberry Pi</a> in your home is a good solution) and storage volume (2TB is a suitable option).
        </p>


        <div class="columns">

            <div class="column  is-half">

                <h2 class="subtitle has-text-weight-light">Categorized Data Types</h2>


                <div class="content">
                    <ul>
                        <li>Image</li>
                        <li>Audio</li>
                        <li>Video</li>
                        <li>Docs (Pdf/Doc etc ...)</li>
                        <li>Other : Any file that you can think of</li>
                    </ul>
                </div>

            </div>

            <div class="column is-half">
                <figure class="image is-1by1">
                    <img src="images/assets.svg" alt="assets" on:click="{showImg}">
                </figure>
            </div>

        </div>

    </section>


@endsection
