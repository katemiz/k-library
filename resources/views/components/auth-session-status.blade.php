@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'notification is-primary is-light']) }}>
        {{ $status }}
    </div>
@endif


{{-- @if (session('status') == 'verification-link-sent')
<div class="notification is-primary">
    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
</div>
@endif --}}
