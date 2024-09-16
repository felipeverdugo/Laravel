<x-slot name="header">
    <h2 class="text-center">Aplicaciones del vacunatorio {{ $zona }}</h2>
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
            <!-- <button wire:click="create()" class="flex bg-vacunasist text-white font-bold py-2 px-4 rounded my-3 float-right">Sacar turno</button> -->
            @if($isModalOpen)
            @include('livewire.aplicacionesEnfermero.edit')
            @endif
            @if(count($aplicaciones) === 0)
            <h4> Hoy no hay aplicaciones en el vacunatorio de la zona {{' ' . Auth::user()->vacunatorio->nombre . '.' }}</h4>
            @endif
            @if(count($aplicaciones) > 0)
            <div class="w-full mt-8">


                <table class="table-fixed w-full mb-2">

                    <thead>

                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">Vacuna</th>
                            <th class="px-4 py-2">Paciente</th>
                            <th class="px-4 py-2">Turno programado</th>
                            <th class="px-4 py-2">Estado</th>
                            <th class="px-4 py-2">Fecha de aplicacion</th>
                            <th class="px-4 py-2">Zona</th>
                            <th class="px-2 py-2">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($aplicaciones as $aplicacion)
                        <tr>
                            <td class="border px-4 py-2 text-center">{{ $aplicacion->vacuna->nombre }}</td>
                            <td class="border px-4 py-2 text-center">{{ $aplicacion->paciente->name . ' ' . $aplicacion->paciente->last_name}}</td>
                            <td class="border px-4 py-2 text-center">{{ $aplicacion->fecha_turno? $aplicacion->fecha_turno->format('d-m-Y h:i'):'No aplica'}}</td>
                            <td class="border px-4 py-2 text-center">{{ $aplicacion->estado }}</td>
                            <td class="border px-4 py-2 text-center">{{ $aplicacion->fecha_aplicacion? $aplicacion->fecha_aplicacion->format('d-m-Y'): ''}}</td>
                            <td class="border px-4 py-2 text-center">{{ $aplicacion->vacunatorio? $aplicacion->vacunatorio->nombre : 'No aplica' }}</td>

                            <td class="border px-2 py-2 text-center">
                                <!-- <button wire:click="edit({{ $aplicacion->id }})" class="bg-blue-500  text-white font-bold py-2 px-4 rounded">Editar</button> -->
                                @if($aplicacion->estado === "PENDIENTE")
                                <button wire:click="edit({{ $aplicacion->id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Validar</button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            @endif
        </div>
    </div>
</div>