{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in!
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

 --}}







@extends('layouts.layout')


@section('content')


    <section class="hero is-medium is-light has-background-primary-light has-background">


        <figure class="image is-16by9">
            <img alt="library" class="hero-background" src="images/library2.svg">
        </figure>

    </section>


    <section class="section container">

        <header class="my-6">
            <h1 class="title has-text-weight-light is-size-1">Personal Digital Library</h1>
            <h2 class="subtitle has-text-weight-light">Private, Just for you</h2>
        </header>




    </section>


@endsection

