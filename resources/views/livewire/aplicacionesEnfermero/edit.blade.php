<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <form>
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="">
                        <h5>Paciente: {{$aplicacion->paciente->name . ' ' . $aplicacion->paciente->last_name}}</h5>
                        <h5>Vacuna: {{$aplicacion->vacuna->nombre}}</h5>
                        <div class="mb-4">

                            <input type="hidden" value="{{$aplicacion_id}}"wire:model="aplicacion_id">
                            <div class="mt-4">
                                <x-jet-label for="laboratorio" value="Escriba el nombre del laboratorio" />
                                <x-jet-input  wire:model="laboratorio" id="laboratorio" class="block mt-1 w-full" type="text" name="laboratorio" :value="old('laboratorio')" required autofocus autocomplete="laboratorio" />
                                @if($errors->has('laboratorio'))
                                <p class="mt-2 text-sm text-red-600">{{ $errors->first('laboratorio') }}</p>
                                @endif
                            </div>
                            <div class="mt-4">
                                <x-jet-label for="lote" value="Escriba el lote de la aplicacion realizada" />
                                <x-jet-input  wire:model="lote" id="lote" class="block mt-1 w-full" type="text" name="lote" :value="old('lote')" required autofocus autocomplete="lote" />
                                @if($errors->has('lote'))
                                <p class="mt-2 text-sm text-red-600">{{ $errors->first('lote') }}</p>
                                @endif
                            </div>
                            <div class="mt-4">
                                <x-jet-label for="obs" value="Observaciones" />
                                <textarea  wire:model="obs" id="obs" class="block mt-1 w-full" type="text" name="obs">
                                </textarea>
                                  @if($errors->has('obs'))
                                <p class="mt-2 text-sm text-red-600">{{ $errors->first('obs') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                <button wire:click.prevent="store()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-bold text-white shadow-sm hover:bg-red-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                    Guardar
                                </button>
                            </span>
                            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                                <button wire:click="closeModalPopover()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-bold text-gray-700 shadow-sm hover:text-gray-700 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                    Cerrar
                                </button>
                            </span>
                        </div>
            </form>
        </div>
    </div>
</div>