<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <!-- <x-jet-validation-errors class="mb-4" /> -->

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div>
                <x-jet-label for="dni" value="DNI" />
                <x-jet-input id="dni" class="block mt-1 w-full" type="text" maxlength="8" name="dni" :value="old('dni')" required autofocus autocomplete="dni" />
                @if($errors->has('dni'))
                <p class="mt-2 text-sm text-red-600">{{ $errors->first('dni') }}</p>
                @endif
            </div>
            <div>
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                @if($errors->has('name'))
                <p class="mt-2 text-sm text-red-600">{{ $errors->first('name') }}</p>
                @endif
            </div>
            <div>
                <x-jet-label for="last_name" value="Apellido" />
                <x-jet-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autofocus autocomplete="last_name" />
                @if($errors->has('last_name'))
                <p class="mt-2 text-sm text-red-600">{{ $errors->first('last_name') }}</p>
                @endif
            </div>
            <div>
                <x-jet-label for="fecha_nac" value="Fecha de nacimiento" />
                <x-jet-input id="fecha_nac" class="block mt-1 w-full" type="date" name="fecha_nac" :value="old('fecha_nac')" required autofocus autocomplete="fecha_nac" />
                @if($errors->has('fecha_nac'))
                <p class="mt-2 text-sm text-red-600">{{ $errors->first('fecha_nac') }}</p>
                @endif
            </div>
            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                @if($errors->has('email'))
                <p class="mt-2 text-sm text-red-600">{{ $errors->first('email') }}</p>
                @endif
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                @if($errors->has('password'))
                <p class="mt-2 text-sm text-red-600">{{ $errors->first('password') }}</p>
                @endif
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>
            <div>
                <h4 class="mt-2 mb-2">Adicionalmente le solicitamos que complete sólo en caso afirmativo</h4>
            </div>
            <div>
                <x-jet-label for="vacuna_covid" value="¿Cuando se vacunó para Covid?" />
                <x-jet-input id="vacuna_covid" class="block mt-1 w-full" type="date" name="vacuna_covid" :value="old('vacuna_covid')" autofocus autocomplete="vacuna_covid" />
                @if($errors->has('vacuna_covid'))
                <p class="mt-2 text-sm text-red-600">{{ $errors->first('vacuna_covid') }}</p>
                @endif
            </div>
            <div>
                <x-jet-label for="vacuna_fiebre" value="¿Cuando se vacunó para la Fiebre amarilla?" />
                <x-jet-input id="vacuna_fiebre" class="block mt-1 w-full" type="date" name="vacuna_fiebre" :value="old('vacuna_fiebre')" autofocus autocomplete="vacuna_fiebre" />
                @if($errors->has('vacuna_fiebre'))
                <p class="mt-2 text-sm text-red-600">{{ $errors->first('vacuna_fiebre') }}</p>
                @endif
            </div>
            <div>
                <x-jet-label for="vacuna_gripe" value="¿Cuando se vacunó para la gripe?" />
                <x-jet-input id="vacuna_gripe" class="block mt-1 w-full" type="date" name="vacuna_gripe" :value="old('vacuna_gripe')" autofocus autocomplete="fecha_nac" />
                @if($errors->has('vacuna_gripe'))
                <p class="mt-2 text-sm text-red-600">{{ $errors->first('vacuna_gripe') }}</p>
                @endif
            </div>
         

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('Register') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>