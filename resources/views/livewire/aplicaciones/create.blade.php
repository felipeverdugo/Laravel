<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <form>
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                @if($errors->has('vacuna_id'))
                                <p class="mt-2 text-sm text-red-600">{{ $errors->first('vacuna_id') }}</p>
                                @endif
                    <div class="">
                        <div class="mb-4">
                            <label for="vacuna" class="block text-gray-700 text-sm font-bold mb-2">¿Qué vacuna se quiere aplicar?</label>
                            @foreach($vacunas as $key=>$vacuna)
                            <div class="form-check">

                                <input value="{{$vacuna->id}}" class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="flexRadio{{$vacuna->id}}" id="flexRadio{{$vacuna->id}}" wire:model="vacuna_id" />
                                <label class="form-check-label inline-block text-gray-800" for="flexRadioDefault1" wire:model="vacuna_id">
                                    {{ $vacuna->nombre }} {{$vacuna->restriccion_etarea? '(mayores de 60)' : ''}}
                                    {{$vacuna->requiere_validacion? '(debe ser aprobada por un administrador)': ''}}
                                </label>
                            </div>
                            @endforeach
                            <label for="vacunatorio" class=" mt-2 block text-gray-700 text-sm font-bold mb-2">¿Qué zona prefiere?</label>

                            @foreach($vacunatorios as $key=>$vacunatorio)
                            <div class="form-check">
                                <input value="{{$vacunatorio->id}}" class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="vacunatorio_{{$vacunatorio->id}}" id="vacunatorio_{{$vacunatorio->id}}" wire:model="vacunatorio_id" />
                                <label class="form-check-label inline-block text-gray-800" for="vacunatorio_{{$vacunatorio->id}}" wire:model="vacunatorio_id">
                                    {{ $vacunatorio->nombre }}

                                </label>
                            </div>
                            @endforeach


                        </div>
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