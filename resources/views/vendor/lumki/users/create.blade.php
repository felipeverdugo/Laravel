<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nuevo Usuario
        </h2>
    </x-slot>
    <form method="POST" action="{{ route('lumki.users.store') }}">
        @csrf
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="space-y-10">
                        <div class="px-4 py-5 sm:p-6 bg-white shadow sm:rounded-lg">
                            <div>
                                <x-jet-label for="name" value="Nombre de usuario" />
                                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                @if($errors->has('name'))
                                <p class="mt-2 text-sm text-red-600">{{ $errors->first('name') }}</p>
                                @endif
                            </div>
                            <div>
                                <x-jet-label for="dni" value="DNI" />
                                <x-jet-input id="dni" class="block mt-1 w-full" type="text" maxlength="8" name="dni" :value="old('dni')" required autofocus autocomplete="dni" />
                                @if($errors->has('dni'))
                                <p class="mt-2 text-sm text-red-600">{{ $errors->first('dni') }}</p>
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
                                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                                @if($errors->has('password'))
                                <p class="mt-2 text-sm text-red-600">{{ $errors->first('password') }}</p>
                                @endif
                            </div>
                            <div class="mt-4">
                                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                            </div>
                            @if($errors->has('vacunatorio_id'))
                            <p class="mt-2 text-sm text-red-600">Seleccione un vacunatorio</p>
                            @endif
                            @foreach ($vacunatorios as $vacunatorio)
                            <div class="mt-4 form-check">
                                <input for="vacunatorio_id" value="{{$vacunatorio->id}}" class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="vacunatorio_id" id="vacunatorio_id" />
                                <label for="vacunatorio_id" class="form-check-label inline-block text-gray-800">
                                    {{ $vacunatorio->nombre }}
                                </label>
                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="space-y-10">
                        <div class="px-4 py-5 sm:p-6 bg-white shadow sm:rounded-lg">
                            <div class="space-y-6">
                                @foreach ($roles as $role)
                                <div class="flex items-center justify-between">
                                    <label class="flex items-center">
                                        <input name="roles[]" type="radio" class="form-checkbox" value="{{ $role->name }}">
                                        <span class="ml-2 text-sm text-gray-600">{{ $role->name }}</span>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                            Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-app-layout>