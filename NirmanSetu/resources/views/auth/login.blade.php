<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="max-w-md mx-auto">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- Login Buttons -->
        <div class="mt-6 space-y-4">
            <div class="flex justify-between items-center">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <!-- Log in Button -->
                <button
                    type="submit"
                    class="flex-1 px-5 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                    {{ __('Log in') }}
                </button>

                <!-- Google Login Button -->
                <a href="{{ route('google.login') }}"
                   class="flex-1 inline-flex items-center justify-center px-5 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
                    <svg class="w-5 h-5 mr-2" viewBox="0 0 488 512" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M488 261.8c0-17.8-1.5-35.1-4.3-51.8H249v98h134c-5.8 31.4-23.5 57.9-50 75.8v62.7h80.9c47.4-43.7 74.1-108.1 74.1-184.7z"/>
                        <path d="M249 500c67.2 0 123.6-22.3 164.8-60.6l-80.9-62.7c-22.6 15.2-51.5 24.2-83.9 24.2-64.6 0-119.3-43.6-138.9-102.3H27.6v64.5C68.2 455.1 152.4 500 249 500z"/>
                        <path d="M110.1 303.6c-6.2-18.7-9.7-38.7-9.7-59.6s3.5-40.9 9.7-59.6V120H27.6C10.1 154.6 0 195.4 0 244s10.1 89.4 27.6 124h82.5v-64.4z"/>
                        <path d="M249 97.1c35.4 0 67.2 12.2 92.4 36.2l69.3-69.3C372.6 27.1 318.2 0 249 0 152.4 0 68.2 44.9 27.6 120l82.5 64.5C129.7 140.7 184.4 97.1 249 97.1z"/>
                    </svg>
                    Continue with Google
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
