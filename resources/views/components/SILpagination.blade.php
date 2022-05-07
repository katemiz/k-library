@props(['pagination' => false])

{{-- <pre>
@php
    print_r($pagination)
@endphp
</pre> --}}


@if ($pagination["last_page"] > 1)

    <nav class="pagination is-small is-centered" aria-label="pagination">

        @if ($pagination["prev_page_url"] !== null)
            <a
                class="pagination-previous {{!$pagination["prev_page_url"] ? 'is-disabled' : ''}}"
                href={{$pagination["prev_page_url"] ? $pagination["prev_page_url"] : '#'}}>

                <x-icon icon="previous-page" fill="{{config('constants.icons.color')}}"/>

            </a>
        @endif

        @if ($pagination["next_page_url"] !== null)

            <a
                class="pagination-next {{!$pagination["next_page_url"] ? 'is-disabled' : ''}}"
                href={{$pagination["next_page_url"] ? $pagination["next_page_url"] : '#'}}>

                <x-icon icon="next-page" fill="{{config('constants.icons.color')}}"/>


            </a>
        @endif

        <ul class="pagination-list">

            @foreach ( $pagination["links"] as $i => $link)

                @if ($i > 0 && $i < count($pagination["links"])-1 )
                    <li>
                    <a
                        class="pagination-link {{ $link["active"] ? 'is-current' : ''}}"
                        href={{$link["url"]}}
                        aria-label="Goto page {{$link["url"]}}">
                        {{$link["label"]}}
                    </a>
                    </li>
                @endif
            @endforeach

        </ul>
    </nav>

@endif
