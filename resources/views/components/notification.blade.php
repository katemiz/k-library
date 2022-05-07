@if ($notification)

    @switch()
        @case('success')
            <div class="notification is-success is-light">
            @break

        @case('info')
            <div class="notification is-info is-light">
            @break

        @case('warning')
            <div class="notification is-warning is-light">
            @break

        @case('danger')
            <div class="notification is-danger is-light">
            @break

        @case('warning')
            <div class="notification is-warning is-light">
            @break

        @default
            <div class="notification is-success is-light">

    @endswitch
        {{ $notification["message"] }}
    </div>

@endif
