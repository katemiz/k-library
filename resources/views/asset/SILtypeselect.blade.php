
@extends('layouts.layout')


@section('content')


  <div class="section container">

    <header class="mt-6">
      <h1 class="title is-size-1 has-text-weight-light">
        Asset Type Selection
      </h1>
      <h1 class="subtitle">Select Digital Asset Type</h1>
    </header>

    <div class="columns mt-6">


        @foreach (config('constants.asset_types') as  $atype)


        <div class="column">

          <div class="card">
            <div class="card-image">
              <a href="/assets-form/{{$atype["type"]}}">
                <figure class="image is-4by3">
                  <img src="/images/{{$atype["image"]}}" alt="{{$atype["type"]}}" />
                </figure>
              </a>
            </div>
          </div>

          <div class="card-content">
            <div class="media">

              <div class="media-content has-text-centered">
                <a
                  href="/assets-form/{{$atype["type"]}}"
                  class="title is-5 has-text-weight-light">
                  {{$atype["title"]}}
                </a>
              </div>
            </div>

          </div>

        </div>
        @endforeach

    </div>

  </div>

  @endsection
