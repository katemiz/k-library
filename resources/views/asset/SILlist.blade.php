

@extends('layouts.layout')


@section('content')


<div class="section container">

    <header class="mt-6">
        <h1 class="title is-size-1 has-text-weight-light">My Assets</h1>
    </header>

    @if ($notification)
        <x-notification notification="{{$notification}}"/>
    @endif

    <!-- ***************** -->
    <!-- ADD BUTTON        -->
    <!-- ***************** -->

    <div class="column">

    <div class="buttons has-addons is-left">

        <a href="/simpleitem-form/{pagetype}" class="button is-light">
            <span class="icon is-small">
                <x-carbon-add-alt class="{{config('constants.icons.size')}}" style="color: {{config('constants.icons.color')}}"/>
            </span>
            <span>Add Asset</span>
        </a>

    </div>
    </div>

    <!-- ************************ -->
    <!-- Filter Tree Search Box   -->
    <!-- ************************ -->

    <div class="columns is-mobile">

        <div class="column">

            <!-- Filter Tree Search Box -->
            <div class="field has-addons is-fullwidth is-pulled-right">

                <livewire:filter-box />

                <p class="control">
                    <button class="button is-link is-light px-1">
                        <x-icon icon="cancel" fill="{{config('constants.icons.color')}}"/>
                    </button>

                </p>
            </div>

        </div>
    </div>













    @if (count($assets) > 0)


    <!-- ************************ -->
    <!-- TABLE                    -->
    <!-- ************************ -->


    <table class="table is-fullwidth">

        <caption>Total <b>{{count($assets)}}</b> Results</caption>

        <thead>
        <tr>
            <th>
                <a class="icon-text" href="/getall?sc=title&so={{$sortorders["title"]}}">
                    <span class="icon {{$sortorders["title"] == 'desc' ? 'is-hidden': ''}}">
                        <x-carbon-chevron-sort-down class="{{config('constants.icons.size')}}" style="color: {{config('constants.icons.color')}}"/>
                    </span>
                    <span class="icon {{$sortorders["title"] == 'asc' ? 'is-hidden': ''}}">
                        <x-carbon-chevron-sort-up class="{{config('constants.icons.size')}}" style="color: {{config('constants.icons.color')}}"/>
                    </span>
                    <span>Title</span>
                </a>
            </th>

            <th class="is-2">
                <a class="icon-text" href="/getall?sc=created_at&so={{$sortorders["created_at"]}}">
                    <span class="icon {{$sortorders["created_at"] == 'desc' ? 'is-hidden': ''}}">
                        <x-carbon-chevron-sort-down class="{{config('constants.icons.size')}}" style="color: {{config('constants.icons.color')}}"/>
                    </span>
                    <span class="icon {{$sortorders["created_at"] == 'asc' ? 'is-hidden': ''}}">
                        <x-carbon-chevron-sort-up class="{{config('constants.icons.size')}}" style="color: {{config('constants.icons.color')}}"/>
                    </span>
                    <span>Created At</span>
                </a>
            </th>

            <th class="has-text-right is-2">
                Actions
            </th>
        </tr>
        </thead>

        <tbody>



            @foreach ($assets["data"] as $item)
            <tr>
                <td>
                    <a href="/simpleitem/{pagetype}/{item.id}">
                        {{$item["title"]}}
                    </a>

                    {!! $item["notes"] !!}
                </td>



                <td>{{$item["created_at"]}}</td>

                <td class="has-text-right">
                <a href="/simpleitem/{pagetype}/{item.id}" class="icon">
                    <x-carbon-view class="{{config('constants.icons.size')}}" style="color: {{config('constants.icons.color')}}"/>
                </a>
                <a href="/simpleitem-form/{pagetype}/{item.id}" class="icon">
                    <x-carbon-edit class="{{config('constants.icons.size')}}" style="color: {{config('constants.icons.color')}}"/>

                </a>
                </td>
            </tr>

            @endforeach

        </tbody>

    </table>

    <x-pagination :pagination="$assets"/>

    @else

    <!-- ************************ -->
    <!-- NO ITEM IN DB            -->
    <!-- ************************ -->

    <div class="notification is-warning is-light">No data in system yet!</div>

    @endif



</div>

@endsection
