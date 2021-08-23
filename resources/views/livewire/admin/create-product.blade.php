<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-gray-700">
    <h1 class="text-3xl text-center font-semibold mb-8">Complete esta informacion para crear un producto</h1>
    <div class="bg-white shadow-xl rounded-lg p-6">
        <div class="grid grid-cols-2 gap-6 mb-4">
            {{-- Categoria --}}
            <div>
                <x-jet-label value="Categorías"></x-jet-label>
                <select class="w-full form-control" wire:model="category_id">
                    <option value="" selected disabled>Seleccione una categoría</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="category_id"></x-jet-input-error>
            </div>
            {{-- Subcategoria --}}
            <div>
                <x-jet-label value="Subcategorías"></x-jet-label>
                <select class="w-full form-control" wire:model="subcategory_id">
                    <option value="" selected disabled>Seleccione una Subcategoría</option>
                    @foreach ($subcategories as $subcategory)
                        <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="subcategory_id"></x-jet-input-error>
            </div>
        </div>
        {{-- Nombre --}}
        <div class="mb-4">
            <x-jet-label value="Nombre"></x-jet-label>
            <x-jet-input wire:model="name" class="w-full" type="text" placeholder="Ingrese el nombre del producto">
            </x-jet-input>
            <x-jet-input-error for="name"></x-jet-input-error>
        </div>
        {{-- Slug --}}
        <div class="mb-4">
            <x-jet-label value="Slug"></x-jet-label>
            <x-jet-input wire:model="slug" class="w-full bg-gray-200" type="text" disabled
                placeholder="Ingrese el slug del producto"></x-jet-input>
            <x-jet-input-error for="slug"></x-jet-input-error>
        </div>
        {{-- Descripcion --}}
        <div class="mb-4">
            <div wire:ignore>
                <x-jet-label value="Descripcion"></x-jet-label>
                <textarea wire:model="description" class="w-full form-control" rows="4" x-data x-init="ClassicEditor
            .create( $refs.miEditor)
            .then(function(editor){
                editor.model.document.on('change:data',()=>{
                    @this.set('description',editor.getData())
                })
            })
            .catch( error => {
                console.error( error );
            } );" x-ref="miEditor"></textarea>
            </div>
            <x-jet-input-error for="description"></x-jet-input-error>
        </div>

        <div class="grid grid-cols-2 gap-6 mb-4">
            {{-- Marca --}}
            <div>
                <x-jet-label value="Marca"></x-jet-label>
                <select class="form-control w-full" wire:model="brand_id">
                    <option value="" selected disabled>Seleccione una marca</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="brand_id"></x-jet-input-error>
            </div>
            {{-- Precio --}}
            <div>
                <x-jet-label value="Precio"></x-jet-label>
                <x-jet-input wire:model="price" type="number" class="w-full" step=".01"></x-jet-input>
                <x-jet-input-error for="price"></x-jet-input-error>
            </div>
        </div>
        @if ($subcategory_id)
            @if (!$this->subcategory->color && !$this->subcategory->size)
                <div>
                    <x-jet-label value="Cantidad"></x-jet-label>
                    <x-jet-input wire:model="quantity" type="number" class="w-full"></x-jet-input>
                    <x-jet-input-error for="quantity"></x-jet-input-error>
                </div>
            @endif
        @endif
        <div class="flex mt-4">
            <x-jet-button wire:loading.attr="disabled" wire:target="save" class="ml-auto" wire:click="save">
                Crear producto
            </x-jet-button>
        </div>
    </div>
</div>
