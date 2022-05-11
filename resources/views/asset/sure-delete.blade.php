@extends('layouts.layout')

@section('content')

<div class="section container">

    <header>
        <h1 class="title is-size-1 has-text-weight-light">Delete Asset</h1>
        <h1 class="subtitle">Are you sure ?</h1>
    </header>

    <div class="columns">

        <div class="column is-half">
            <article class="message is-warning my-6">
                <div class="message-header">
                  <p>Warning : Asset Delete</p>
                </div>
                <div class="message-body">
                  <p class="my-3">With this asset also all attached files ({{count($asset->attachments)}} total) will be deleted!</p>
                  <p class="my-3">This is <strong>IRREVERSIBLE</strong> action. Handle wih care.</p>
                </div>
            </article>
        </div>

        <div class="column">
            <figure class="image">
                <img alt="asset delete" src="{{asset('images/asset_delete.svg')}}">
            </figure>
        </div>

    </div>



    <!-- Main container -->
    <nav class="level">
        <!-- Left side -->
        <div class="level-left">
            <a href={{"/assets-view/".$asset->id}} class="button is-link is-light is-fullwidth">
                <x-icon icon="undo" fill="{{config('constants.icons.color.active')}}"/>&nbsp;
                Ooops ...
            </a>
        </div>

        <!-- Right side -->
        <div class="level-right">
            <a href={{"/delete/".$asset->random}} class="button is-danger is-light is-fullwidth">
                <x-icon icon="delete" fill="{{config('constants.icons.color.danger')}}"/>&nbsp;
                Sure. Delete Everything
            </a>
        </div>
    </nav>

</div>
@endsection
