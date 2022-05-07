{{-- <x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                    type="password"
                                    name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Reset Password') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>

 --}}






<x-guest-layout>

    <form method="POST" class="mx-4" action="{{ route('password.update') }}">
        @csrf

        <!-- Validation Errors -->
        <x-auth-validation-errors class="notification is-danger is-light" :errors="$errors" />

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <x-email name="email" :value="old('email')" />


        <!-- Password -->
        <x-password name="password" label="{{__('Password')}}" :value="old('password')" placeholder="{{__('Your Password')}}" />

        <!-- Password , Confirm-->
        <x-password name="password_confirmation" label="{{__('Confirm Password')}}" :value="old('password_confirmation')" placeholder="{{__('Confirm Password')}}" />

        <button class="button is-dark my-6 is-fullwidth">{{ __('Reset Password') }}</button>

    </form>

</x-guest-layout>
