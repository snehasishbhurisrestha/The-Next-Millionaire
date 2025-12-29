<x-guest-layout>
    @section('title','Reset Password')
    @section('login-title','Reset Your Password')

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email -->
        <div class="form-group">
            <x-text-input 
                id="email" 
                type="email" 
                name="email" 
                class="block mt-1 w-full form-control"
                placeholder="Enter email"
                :value="old('email', $request->email)" 
                required 
                autofocus 
                autocomplete="username" 
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
        </div>

        <!-- Password -->
        <div class="form-group mt-4">
            <x-text-input 
                id="password" 
                type="password" 
                name="password" 
                class="block mt-1 w-full form-control"
                placeholder="Enter new password"
                required 
                autocomplete="new-password" 
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
        </div>

        <!-- Confirm Password -->
        <div class="form-group mt-4">
            <x-text-input 
                id="password_confirmation" 
                type="password" 
                name="password_confirmation" 
                class="block mt-1 w-full form-control"
                placeholder="Confirm password"
                required 
                autocomplete="new-password" 
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger" />
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-block" style="background-color:#0d0e0e; color:rgb(142,142,41); font-weight:900; font-size:22px;">
                Reset Password
            </button>
        </div>

    </form>
</x-guest-layout>
