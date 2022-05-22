@extends('layouts.layout')


@section('content')


    <section class="hero is-medium ">


        <figure class="image is-16by9">
            <img alt="library" class="hero-background" src="images/library.svg">
        </figure>

    </section>


    <section class="section container">

        <header class="my-6">
            <h1 class="title has-text-weight-light is-size-1">Personal Digital Library - PDL</h1>
            <h2 class="subtitle has-text-weight-light">Private, Only for You</h2>
        </header>

        <p class="mb-3">
        Competency is a set of skills, related knowledge and attributes that allow an individual to perform a task or an activity within a specific function or job. Therefore it is important for the success of the Organization in achieving its strategic goals, as well as the success of individual employee. Any function in the Organization requires a set of essential managerial/generic and technical/functional competencies to be performed effectively.
        </p>


        <div class="columns">

            <div class="column  is-half">

                <h2 class="subtitle has-text-weight-light">Data Types</h2>


                <div class="content">
                    <ul>
                        <li>Books</li>
                        <li>Videos</li>
                        <li>Photos/Images</li>
                        <li>Any file that you can think of</li>
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
