<x-app-layout>

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

                    @php
                        $i = 0
                    @endphp

                    @foreach (Config::get('constants.datatypes') as $key => $dtype)

                        @if ($i % 3 === 0)
                        <tr>
                        @endif

                        <td class="has-text-centered">
                            <p class="heading">{{$dtype}}</p>
                            <p class="title"><a href="/list-records/{{$key}}">{{$counts[$key]}}</a></p>
                        </td>

                        @php
                        $i++
                        @endphp

                        @if ($i % 3 === 0)
                        </tr>
                        @endif

                    @endforeach

                </table>

            </div>

        </div>

    </section>
</x-app-layout>
