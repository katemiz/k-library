<div class="section container">

    <header class="mt-6">
        <h1 class="title is-size-1 has-text-weight-light">My Assets</h1>
    </header>

    <figure class="image is-16by9">
        <img alt="library" class="hero-background" src="images/library2.svg">
    </figure>

    @if ($notification)
        <x-notification notification="{{$notification}}"/>
    @endif


    <nav class="level my-6">

        <!-- Left side -->
        <div class="level-left">
            <div class="level-item  has-text-centered">
                <a href="/assets-select-type" class="button is-link">
                    <span class="icon is-small">
                        <x-icon icon="plus" fill="{{config('constants.icons.color.light')}}"/>
                    </span>
                    <span>Add Asset</span>
                </a>
            </div>
        </div>

        <!-- Right side -->
        <div class="level-right">

            <div class="level-item">
                <!-- Filter Tree Search Box -->
                <div class="field has-addons is-fullwidth is-pulled-right">

                    <p class="control has-icons-left">
                        <input class="input" type="text" placeholder="Search in my assets ..." wire:model.debounce.500ms="search">
                    <span class="icon is-small is-left">
                        <x-icon icon="search" fill="{{config('constants.icons.color.disabled')}}"/>
                    </span>
                    </p>
                    <p class="control">
                    <a class="button px-1" wire:click="resetFilter">
                        <x-icon icon="cancel" fill="{{config('constants.icons.color.active')}}"/>
                    </a>
                    </p>
                </div>
            </div>
          </div>

    </nav>






    <div>
        @if ($assets->total() > 0)

            <!-- ************************ -->
            <!-- TABLE                    -->
            <!-- ************************ -->
            <table class="table is-fullwidth">

                <caption><b>{{ $assets->total() }}</b> Result{{ $assets->total() > 1 ? 's':'' }}</caption>

                <thead>
                <tr>
                    <th>
                        <span class="icon-text" wire:click="sortBy('title')">
                            <span class="icon {{ $sortDirection === 'asc' ? 'is-hidden' : ''}}">
                                <x-icon icon="arrow-up" fill="{{config('constants.icons.color.active')}}"/>
                            </span>
                            <span class="icon {{ $sortDirection === 'desc' ? 'is-hidden' : ''}}">
                                <x-icon icon="arrow-down" fill="{{config('constants.icons.color.active')}}"/>
                            </span>
                            <span>Title</span>
                        </span>
                    </th>

                    <th class="is-2">
                        <span class="icon-text" wire:click="sortBy('created_at')">
                            <span class="icon {{ $sortTimeDirection === 'asc' ? 'is-hidden' : ''}}">
                                <x-icon icon="arrow-up" fill="{{config('constants.icons.color.active')}}"/>
                            </span>
                            <span class="icon {{ $sortTimeDirection === 'desc' ? 'is-hidden' : ''}}">
                                <x-icon icon="arrow-down" fill="{{config('constants.icons.color.active')}}"/>
                            </span>
                            <span>Created At</span>
                        </span>
                    </th>

                    <th class="has-text-right is-2">Actions</th>
                </tr>
                </thead>

                <tbody>

                    @foreach ($assets as $item)
                    <tr>
                        <td>
                            <a href="/assets-view/{{ $item->id }}">
                                {{$item->title}}
                            </a>

                            {!! $item->notes !!}
                        </td>

                        <td>{{$item->created_at}}</td>

                        <td class="has-text-right">

                            <a href="/assets-view/{{ $item->id }}" class="icon">
                                <x-icon icon="eye" fill="{{config('constants.icons.color.active')}}"/>
                            </a>

                            <a href="/assets-form/{{ $item->id }}" class="icon">
                                <x-icon icon="edit" fill="{{config('constants.icons.color.active')}}"/>
                            </a>
                        </td>
                    </tr>

                    @endforeach

                </tbody>

            </table>



        @else

            <!-- ************************ -->
            <!-- NO ITEM IN DB            -->
            <!-- ************************ -->
            <div class="notification is-warning is-light">No data in system yet!</div>

        @endif
    </div>
    {{ $assets->links() }}

</div>
