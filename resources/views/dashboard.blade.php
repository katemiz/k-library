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


                <nav class="level">
                <div class="level-item has-text-centered">
                  <div>
                    <p class="heading">Assets</p>
                    <p class="title">{{$asset_count}}</p>
                  </div>
                </div>
                <div class="level-item has-text-centered">
                  <div>
                    <p class="heading">Photos</p>
                    <p class="title">{{$photo_count}}</p>
                  </div>
                </div>
                <div class="level-item has-text-centered">
                  <div>
                    <p class="heading">Pdfs</p>
                    <p class="title">{{$pdf_count}}</p>
                  </div>
                </div>

              </nav>

              <nav class="level">

                <div class="level-item has-text-centered">
                  <div>
                    <p class="heading">Music</p>
                    <p class="title">789</p>
                  </div>
                </div>

                <div class="level-item has-text-centered">
                    <div>
                      <p class="heading">Video</p>
                      <p class="title">789</p>
                    </div>
                  </div>

                  <div class="level-item has-text-centered">
                    <div>
                      <p class="heading">Others</p>
                      <p class="title">789</p>
                    </div>
                  </div>
              </nav>


              <nav class="level">

                <div class="level-item has-text-centered">
                  <div>
                    <p class="heading">Music</p>
                    <p class="title">789</p>
                  </div>
                </div>

                <div class="level-item has-text-centered">
                    <div>
                      <p class="heading">Video</p>
                      <p class="title">789</p>
                    </div>
                  </div>

                  <div class="level-item has-text-centered">
                    <div>
                      <p class="heading">Others</p>
                      <p class="title">789</p>
                    </div>
                  </div>
              </nav>




            </div>

        </div>

    </section>

@endsection
