{{-- <x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>

 --}}








<x-guest-layout>

    <!-- Validation Errors -->
    {{-- <x-auth-validation-errors class="notification is-danger is-light content" :errors="$errors" /> --}}

    <form method="POST" class="mx-4" action="{{ route('register') }}">
        @csrf

        <div class="columns">
            <div class="column is-half">
                <!-- Name -->
                <x-input name="name" label="{{__('Name')}}" :value="old('name')" placeholder="{{__('Enter your name')}}"/>
            </div>

            <div class="column">
                <!-- Lastname -->
                <x-input name="lastname" label="{{__('Lastname')}}" :value="old('lastname')" placeholder="{{__('Enter your lastname')}}"/>
            </div>
        </div>

        <!-- Email Address -->
        <x-email name="email" :value="old('email')" />

        <div class="columns">

            <div class="column is-half">
                <!-- Password -->
                <x-password name="password" label="{{__('Password')}}" :value="old('password')" placeholder="{{__('Your Password')}}" />
            </div>

            <div class="column is-half">
                <!-- Password -->
                <x-password name="password_confirmation" label="{{__('Confirm Password')}}" :value="old('password_confirmation')" placeholder="{{__('Confirm Password')}}" />
            </div>
        </div>

        <button class="button is-primary my-6 is-fullwidth">{{ __('Register') }}</button>

        <!-- Other Actions Links -->
        <x-auth-actions action="register"/>

    </form>

</x-guest-layout>
