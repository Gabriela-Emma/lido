<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <img class="block logo" width="200" height="200" src="{{asset('img/llogo-transparent.png')}}"
                alt="lidonation logo" />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 text-sm font-medium text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ url('/login') }}">
            @csrf

            <div>
                <x-jet-label for="email" value="{{ $snippets->email }}" />
                <x-jet-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ $snippets->password }}" />
                <x-jet-input id="password" class="block w-full mt-1" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-jet-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ $snippets->rememberMe }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="text-sm text-gray-600 underline hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ $snippets->forgotYourPassword }}
                    </a>
                @endif

                <x-jet-button class="ml-4">
                    {{ $snippets->login }}
                </x-jet-button>
            </div>
        </form>

        <div>
            <hr />
        </div>

        <div>
            <p>
                Are you a Delegator to the LIDO stake pool?
                <a href="{{route('register')}}">Register</a>
            </p>
        </div>

        <div>
            <hr />
        </div>

        <div>
            <p>
                Learning more about our
                <a href="{{route('phuffycoin')}}">Phuffy</a> initiative.
            </p>
        </div>
    </x-jet-authentication-card>
</x-guest-layout>
