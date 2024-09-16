@php

use App\Models\User;
use Illuminate\Support\Arr;

@endphp
<x-app-layout>
    <x-slot name="header">
        <!-- <h2 class="font-semibold text-xl text-gray-800 leading-tight"> -->
        <h2 class="text-center">
            {{ __('lumki::ui.manage_users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class=" mx-auto sm:px-6 lg:px-8">
            <div class="block mb-8">
                <a href="{{route('lumki.users.create')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full ">Nuevo</a>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="py-2 mb-1">
                    <form method="GET">
                        @php
                        $request = request()
                        @endphp

                        @if ($request->has('sort'))
                        <input type="hidden" name="sort" value="{{ $request->get('sort') }}" />
                        @endif

                        @if ($request->has('direction'))
                        <input type="hidden" name="direction" value="{{ $request->get('direction') }}" />
                        @endif

                        <div class="px-4 py-5 sm:p-6 bg-white shadow sm:rounded-lg">
                            <div class="flex justify-between items-end mb-3">
                                <div class="flex-auto self-stretch">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Roles</label>
                                    <div>

                                        @foreach ($roles as $i => $rol)
                                        <label class="mr-2">
                                            {{ $rol->name }}
                                            <input type="checkbox" value="{{$rol->name }}" name="filtros[rol][]" {{  ( in_array($rol->name, $filtros['rol']) ) ? 'checked="checked"' : '' }} />
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="flex-auto mx-2">
                                    <label for="input-descripcion" class="block text-gray-700 text-sm font-bold mb-2">
                                        DNI
                                    </label>
                                    <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="filtros[dni]" id="input-usuario" value="{{ $filtros['dni'] }}" placeholder="Buscar por DNI de usuario..." />
                                </div>
                                <div class="flex-auto mx-2">
                                    <label for="input-descripcion" class="block text-gray-700 text-sm font-bold mb-2">
                                        Usuario
                                    </label>
                                    <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="filtros[name]" id="input-usuario" value="{{ $filtros['name'] }}" placeholder="Buscar por nombre de usuario..." />
                                </div>
                                <div class="flex-auto mx-2">

                                    <label class="mr-2">
                                        Ocultar usuarios bloqueados
                                        <input type="checkbox" name="ocultarBloqueados" {{ $filtros['blocked'] ? 'checked="checked"' : '' }} /> 
                                    </label>
                                    
                                </div>
                                <div class="flex-none">
                                    <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-6 rounded">Filtrar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="ml-5 py-2 mb-1">
                    {{ $users->links() }}
                </div>
                @if(count($users)>0)
                <table class="table-fixed w-full mb-2">
                    <thead>
                        @php
                        $defaultQueryParams = [ 'page' => $users->currentPage() ];
                        @endphp
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 w-1/8 text-center">
                                @sortablelink('name', 'Usuario', $defaultQueryParams)</th>
                            <th class="px-4 py-2">@sortablelink('dni', 'dni', $defaultQueryParams)</th>
                            <th class="px-4 py-2" colspan="4">Roles</th>
                            <th class="px-4 py-2">Acciones</th>

                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($users as $user)
                        <tr>
                            <td class="border px-4 py-2 text-left">
                                {{ $user->nombreCompleto }}
                            </td>
                            <td class="border px-4 py-2 text-center">
                                {{ $user->dni }}
                            </td>
                            <td colspan="4" class="border px-4 py-2 text-center">
                                {{ $user->getRoleNames()->join(", ") }}
                            </td>

                            <td class="border px-4 py-2 text-center ">

                                @php
                                $currentUser = auth()->user();
                                @endphp
                                @if ( ! $user->is($currentUser))
                                <form method="POST" action="{{ route('users.block', ['user' => $user]) }}">
                                    @csrf
                                    <button type="submit" @class([ "cursor-pointer" , "ml-6" , "text-sm" , "focus:outline-none" , "text-red-500"=> !$user->blocked,
                                        "text-green-500" => $user->blocked
                                        ])>
                                        {{ $user->blocked ? 'Desbloquear' : 'Bloquear' }}
                                    </button>
                                </form>
                                @endif
                                <button class="cursor-pointer ml-6 text-sm text-blue-500 focus:outline-none">
                                    <a href="{{ route('lumki.users.edit', $user) }}">Editar</a>
                                </button>
                                @if ( ! $user->is($currentUser))
                                <button class="cursor-pointer ml-6 text-sm text-red-500 focus:outline-none">
                                    <a href="{{ route('impersonate', $user->id) }}">{{ __('lumki::ui.impersonate') }}</a>
                                </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <table class="table-fixed w-full mb-2">
                    <div>
                        <span>No hay datos para mostrar</span>
                    </div>
                </table>
                @endif

            </div>
        </div>
        <!-- <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
            {{ $users->links() }}
        </div> -->
    </div>
    </div>
    </div>

</x-app-layout>