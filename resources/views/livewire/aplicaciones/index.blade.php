<x-slot name="header">
    <h2 class="text-center">Mis aplicaciones</h2>
</x-slot>
<div class="py-12 w-full">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 w-full">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4 ">
            @if (session()->has('message'))
            <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
                <div class="flex">
                    <div>
                        <p class="text-sm">{{ session('message') }}</p>
                    </div>
                </div>
            </div>
            @endif
            <button wire:click="create()" class="flex bg-vacunasist text-white font-bold py-2 px-4 rounded my-3 float-right">Sacar turno</button>
            @if($isModalOpen)
            @include('livewire.aplicaciones.create')
            @endif
            @if(!Auth::user()->tieneAplicaciones)
            <h4> Aun no tiene aplicaciones cargadas.</h4>
            @endif
            <br/>
            @if(Auth::user()->tieneAplicaciones)
            @if(count($aplicacionesPendientes)>0)
            <div class="w-full mt-8">

                <h4 class="w-full mb-2">Pendientes</h4>
                <table class="table-fixed w-full mb-2">

                    <thead>

                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">Vacuna</th>
                            <th class="px-4 py-2">Fecha solicitud</th>
                            <th class="px-4 py-2">Turno programado</th>
                            <th class="px-4 py-2">Estado</th>
                            <th class="px-4 py-2">Fecha de aplicacion</th>
                            <th class="px-4 py-2">Zona</th>
                            <th class="px-2 py-2">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($aplicacionesPendientes as $aplicacion)
                        <tr>
                            <td class="border px-4 py-2 text-center">{{ $aplicacion->vacuna->nombre }}</td>
                            <td class="border px-4 py-2 text-center">{{ $aplicacion->fechaSolicitud }}</td>
                            <td class="border px-4 py-2 text-center">{{ $aplicacion->fecha_turno? $aplicacion->fecha_turno->format('d-m-Y'):'No aplica'}}</td>

                            <!-- <td class="border px-4 py-2 text-center">{{ $aplicacion->fecha_turno? $aplicacion->fecha_turno->format('d-m-Y h:i'):'No aplica'}}</td> -->
                            <td class="border px-4 py-2 text-center">{{ $aplicacion->estado }}</td>
                            <td class="border px-4 py-2 text-center">{{ $aplicacion->fecha_aplicacion? $aplicacion->fecha_aplicacion->format('d-m-Y'): ''}}</td>
                            <td class="border px-4 py-2 text-center">{{ $aplicacion->vacunatorio? $aplicacion->vacunatorio->nombre : 'No aplica' }}</td>

                            <td class="border px-2 py-2 text-center">
                                <!-- <button wire:click="edit({{ $aplicacion->id }})" class="bg-blue-500  text-white font-bold py-2 px-4 rounded">Editar</button> -->
                                @if($aplicacion->estado === "PENDIENTE")
                                <button wire:click="delete({{ $aplicacion->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Eliminar turno</button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
            <div class="mt-2">

                <h4 class="mb-2">
                    Histórico
                </h4>
                <table class="table-fixed w-full mb-2">

                    <thead>

                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">Vacuna</th>

                            <th class="px-4 py-2">Estado</th>
                            <th class="px-4 py-2">Fecha de aplicacion</th>
                            <th class="px-4 py-2">Zona</th>
                            <th class="px-4 py-2">Lote</th>
                            <th class="px-4 py-2">Laboratorio</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($aplicaciones as $aplicacion)
                        <tr>
                            <td class="border px-4 py-2 text-center">{{ $aplicacion->vacuna->nombre }}</td>
                            <td class="border px-4 py-2 text-center">{{ $aplicacion->estado }}</td>
                            <td class="border px-4 py-2 text-center">{{ $aplicacion->fecha_aplicacion? $aplicacion->fecha_aplicacion->format('d-m-Y'): 'No aplica'}}</td>
                            <td class="border px-4 py-2 text-center">{{ $aplicacion->vacunatorio? $aplicacion->vacunatorio->nombre : 'No aplica' }}</td>
                            <td class="border px-4 py-2 text-center">{{ $aplicacion->lote? $aplicacion->lote : 'No aplica' }}</td>
                            <td class="border px-4 py-2 text-center">{{ $aplicacion->laboratorio? $aplicacion->laboratorio : 'No aplica' }}</td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>