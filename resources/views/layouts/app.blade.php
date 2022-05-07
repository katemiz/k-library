<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />

    <link  rel="icon" type="image/svg+xml" href="{{ asset('/images/favicon.svg') }}" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link  href="{{ asset('/css/app.css') }}" rel="stylesheet" />
    <link  href="{{ asset('/css/bulma.css') }}" rel="stylesheet" />

    <script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>

    @livewireStyles

  </head>
  <body>

    @include('layouts.nav',["user"=>false])

        {{-- @yield('content') --}}
        {{ $slot }}

    @include('layouts.footer')

    @livewireScripts

  </body>
</html>
