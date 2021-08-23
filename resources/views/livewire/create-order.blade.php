<div class="container py-8 grid grid-cols-5 gap-6">
    <div class="col-span-3">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="mb-4">
                <x-jet-label value="Nombre de Contacto"></x-jet-label>
                <x-jet-input
                wire:model.defer="contact"
                type="text"
                placeholder="Ingrese el nombre de la persona que recibira el producto"
                class="w-full">
                </x-jet-input>
                <x-jet-input-error for="contact"></x-jet-input-error>
            </div>
            <div>
                <x-jet-label value="Telefono de contacto"></x-jet-label>
                <x-jet-input
                wire:model.defer="phone"
                type="text"
                placeholder="Ingrese un numero de telefono de contacto"
                class="w-full">
                </x-jet-input>
                <x-jet-input-error for="phone"></x-jet-input-error>
            </div>
        </div>
        <div x-data="{ envio_type:@entangle('envio_type') }">
            <p class="mt-6 mb-3 text-lg text-gray-700 font-semibold">Envios</p>
            <label class="bg-white rounded-lg shadow px-6 py-4 flex items-center mb-4">
                <input x-model="envio_type" type="radio" value="1" name="envio_type" class="text-gray-600">
                <span class="ml-2 text-gray-700">Recojo en tienda(Calle Falsa 123)</span>
                <span class="font-semibold text-gray-700 ml-auto">Gratis</span>
            </label>
            <div class="bg-white rounded-lg shadow">
                <label class=" px-6 py-4 flex items-center">
                    <input x-model="envio_type" type="radio" value="2"  name="envio_type" class="text-gray-600">
                    <span class="ml-2 text-gray-700">Envio a domicilio</span>
                </label>
                <div class="px-6 pb-6 grid grid-cols-2 gap-6 hidden" :class="{'hidden': envio_type!=2}">
                    {{-- Departamentos --}}
                    <div>
                        <x-jet-label value="Departamento" ></x-jet-label>
                        <select class="form-control w-full" wire:model="department_id" >
                            <option value="" disabled selected>Seleccione un Departamento</option>
                            @foreach ($departments as $department)
                                <option value="{{$department->id}}">{{$department->name}}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="department_id"></x-jet-input-error>
                    </div>
                    {{-- Ciudades --}}
                    <div>
                        <x-jet-label value="Ciudad" ></x-jet-label>
                        <select class="form-control w-full" wire:model="city_id" >
                            <option value="" disabled selected>Seleccione una Ciudad</option>
                            @foreach ($cities as $city)
                                <option value="{{$city->id}}">{{$city->name}}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="city_id"></x-jet-input-error>
                    </div>
                    {{-- Distritos --}}
                    <div>
                        <x-jet-label value="Distrito" ></x-jet-label>
                        <select class="form-control w-full" wire:model="district_id" >
                            <option value="" disabled selected>Seleccione un Distrito</option>
                            @foreach ($districts as $district)
                                <option value="{{$district->id}}">{{$district->name}}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="district_id"></x-jet-input-error>
                    </div>
                    <div>
                        <x-jet-label value="Direccion" ></x-jet-label>
                        <x-jet-input wire:model="address" type="text" class="w-full"></x-jet-input>
                        <x-jet-input-error  for="address"></x-jet-input-error>
                    </div>
                    <div class="col-span-2">
                        <x-jet-label value="Referencia" ></x-jet-label>
                        <x-jet-input wire:model="references" type="text" class="w-full"></x-jet-input>
                        <x-jet-input-error for="references"></x-jet-input-error>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <x-jet-button
            class="mt-6 mb-4"
            wire:click="create_order"
            wire:loading.attr='disabled'
            wire:target='create_order'
            >
                Continuar con la compra
            </x-jet-button>
            <hr>
            <p class="text-sm text-gray-700 mt-2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni,
                praesentium corporis hic suscipit adipisci consequatur debitis dicta vero pariatur temporibus, fuga est.
                Culpa recusandae libero assumenda eligendi obcaecati repellat dignissimos? <a href=""
                    class="font-semibold text-orange-500">Politicas y privacidad</a> </p>
        </div>
    </div>
    <div class="col-span-2">
        <div class="bg-white rounded-lg shadow p-6">
            <ul>
                @forelse (Cart::content() as $item)
                    <li class="flex p-2 border-b border-gray-200">
                        <img class="h-15 w-20 object-cover mr-4" src="{{ $item->options->image }}" alt="">
                        <article class="flex-1">
                            <h1 class="font-bold">{{ $item->name }}</h1>
                            <div class="flex">
                                <p>Cant: {{ $item->qty }}</p>
                                @isset($item->options['color'])
                                    <p class="mx-2">- Color: <font class="capitalize">{{ __($item->options['color']) }}
                                        </font>
                                    </p>
                                @endisset
                                @isset($item->options['size'])
                                    <p>
                                        <font class="capitalize">{{ __($item->options['size']) }}</font>
                                    </p>
                                @endisset
                            </div>
                            <p>USD {{ $item->price }}</p>
                        </article>
                    </li>
                @empty
                    <li class="py-6 px-4">
                        <p class="text-center text-gray-700">
                            No tiene agregado ningun item en el carrito
                        </p>
                    </li>
                @endforelse
            </ul>
            <hr class="mt-4 mb-3">
            <div class="text-gray-700">
                <p class="flex justify-between items-center">
                    Subtotal
                    <span class="font-semibold">{{ Cart::subtotal() }} USD</span>
                </p>
                <p class="flex justify-between items-center">
                    Envio
                    <span class="font-semibold">
                        @if ($envio_type==1 || $shipping_cost==0)
                            Gratis
                        @else
                            {{$shipping_cost}} USD
                        @endif
                    </span>
                </p>
                <hr class="mt-4 mb-3">
                <p class="flex justify-between items-center font-semibold">
                    <span class="text-lg">Total</span>
                   @if ($envio_type==1)
                   {{ Cart::subtotal() }} USD
                   @else
                   {{ Cart::subtotal() + $shipping_cost }} USD
                   @endif
                </p>
            </div>
        </div>
    </div>

</div>
