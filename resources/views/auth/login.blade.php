
<x-guest-layout>
    @section('title','Login')
    @section('login-title','Login to your account')
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            {{-- <x-input-label for="email" :value="__('Email')" /> --}}
            <x-text-input id="email" class="block mt-1 w-full form-control" placeholder="Enter email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
        </div>

        <!-- Password -->
        <div class="mt-4 form-group">
            {{-- <x-input-label for="password" :value="__('Password')" /> --}}
            {{-- @if (Route::has('password.request'))
            <label class="form-label"><a href="{{ route('password.request') }}" class="float-right small pb-2" style="color:#c6c630">Forgot password ?</a></label>
            @endif --}}
            <x-text-input id="password" class="block mt-1 w-full form-control"
                            type="password"
                            name="password"
                            placeholder="Password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4 form-group d-flex justify-content-between align-items-center">
            <label for="remember_me" class="inline-flex items-center custom-control custom-checkbox">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 custom-control-input" name="remember">
                <span class="ms-2 text-sm text-gray-600 custom-control-label">{{ __('Remember me') }}</span>
            </label>
            @if (Route::has('password.request'))
            <label class="form-label" style="margin: 0 !important;"><a href="{{ route('password.request') }}" class="float-right small" style="color:#c6c630">Forgot password ?</a></label>
            @endif
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-block" style="background-color: #0d0e0e; color: rgb(142, 142, 41); font-weight: 900; font-size: 22px;">Sign in</button>
            {{-- <div class="text-muted mt-4">Don't have account yet? <a href="{{ route('register') }}">Sign up</a></div> --}}
        </div>
    </form>
</x-guest-layout>