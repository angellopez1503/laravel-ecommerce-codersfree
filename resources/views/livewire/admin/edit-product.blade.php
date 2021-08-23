<div>

    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                    Productos
                </h1>
                <x-jet-danger-button wire:click="$emit('deleteProduct')">
                    Eliminar
                </x-jet-danger-button>
            </div>
        </div>
    </header>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-gray-700">
        <h1 class="text-3xl text-center font-semibold mb-8">Complete esta informacion para actualizar un producto</h1>

        <div class="mb-4" wire:ignore>
            <form action="{{route('admin.products.files',$product)}}"
            method="POST"
            class="dropzone"
            id="my-awesome-dropzone"></form>
        </div>

        @if ($product->images->count())
            <section class="bg-white shadow-xl rounded-lg p-6 mb-4">
                <h1 class="text-2xl text-center font-semibold mb-2">Imagenes del producto</h1>
                <ul class="flex flex-wrap">
                    @foreach ($product->images as $image)
                        <li class="relative" wire:key="image-{{$image->id}}">
                            <img class="w-32 h-20 object-cover" src="{{ Storage::url($image->url) }}" alt="">
                            <x-jet-danger-button
                            class="absolute right-2 top-2"
                            wire:click="deleteImage({{$image->id}})"
                            wire:loading.attr="disabled"
                            wire:target="deleteImage({{$image->id}})"
                            >
                                x
                            </x-jet-danger-button>
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif

        @livewire('admin.status-product', ['product' => $product], key('status-product-'.$product->id))

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
                    <select class="w-full form-control" wire:model="product.subcategory_id">
                        <option value="" selected disabled>Seleccione una Subcategoría</option>
                        @foreach ($subcategories as $subcategory)
                            <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                        @endforeach
                    </select>
                    <x-jet-input-error for="product.subcategory_id"></x-jet-input-error>
                </div>
            </div>
            {{-- Nombre --}}
            <div class="mb-4">
                <x-jet-label value="Nombre"></x-jet-label>
                <x-jet-input wire:model="product.name" class="w-full" type="text" placeholder="Ingrese el nombre del producto">
                </x-jet-input>
                <x-jet-input-error for="product.name"></x-jet-input-error>
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
                    <textarea wire:model="product.description" class="w-full form-control" rows="4" x-data x-init="ClassicEditor
                    .create( $refs.miEditor)
                    .then(function(editor){
                        editor.model.document.on('change:data',()=>{
                            @this.set('product.description',editor.getData())
                        })
                    })
                    .catch( error => {
                        console.error( error );
                    } );" x-ref="miEditor"></textarea>
                </div>
                <x-jet-input-error for="product.description"></x-jet-input-error>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-4">
                {{-- Marca --}}
                <div>
                    <x-jet-label value="Marca"></x-jet-label>
                    <select class="form-control w-full" wire:model="product.brand_id">
                        <option value="" selected disabled>Seleccione una marca</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                    <x-jet-input-error for="product.brand_id"></x-jet-input-error>
                </div>
                {{-- Precio --}}
                <div>
                    <x-jet-label value="Precio"></x-jet-label>
                    <x-jet-input wire:model="product.price" type="number" class="w-full" step=".01"></x-jet-input>
                    <x-jet-input-error for="product.price"></x-jet-input-error>
                </div>
            </div>
            @if ($this->subcategory)
                @if (!$this->subcategory->color && !$this->subcategory->size)
                    <div>
                        <x-jet-label value="Cantidad"></x-jet-label>
                        <x-jet-input wire:model="product.quantity" type="number" class="w-full"></x-jet-input>
                        <x-jet-input-error for="product.quantity"></x-jet-input-error>
                    </div>
                @endif
            @endif
            <div class="flex justify-end items-center  mt-4">
                <x-jet-action-message  class="mr-3" on="saved">
                    Actualizado
                </x-jet-action-message>
                <x-jet-button wire:loading.attr="disabled" wire:target="save"   wire:click="save">
                    Actualizar producto
                </x-jet-button>
            </div>
        </div>

        @if ($this->subcategory)
            @if ($this->subcategory->size)
                @livewire('admin.size-product', ['product' => $product], key('size-product'.$product->id))
            @elseif ($this->subcategory->color)
            @livewire('admin.color-product', ['product' => $product], key('color-product'.$product->id))
            @endif
        @endif


    </div>

    @push('script')

    <script>
        Dropzone.options.myAwesomeDropzone = {
            headers:{
                'X-CSRF-TOKEN':"{{csrf_token()}}"
            },
            dictDefaultMessage:'Arrastre una imagen al recuadro',
            acceptedFiles:'image/*',
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 2,
            complete:function(file){
                this.removeFile(file);
            },
            queuecomplete:function(){
                Livewire.emit('refreshProduct')
            }
            , // MB
            // accept: function(file, done) {
            //     if (file.name == "justinbieber.jpg") {
            //     done("Naha, you don't.");
            //     }
            //     else { done(); }
            // }

            };

            Livewire.on('deleteProduct',()=>{

            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {

                 Livewire.emitTo('admin.edit-product','delete');

                Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
                )
            }
            })

            });


            Livewire.on('deleteColorProduct',pivot=>{

            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {

                Livewire.emitTo('admin.color-product','delete',pivot);

                Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
                )
            }
            })

            });


            Livewire.on('deleteSizeProduct',size=>{

            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {

                Livewire.emitTo('admin.size-product','delete',size);

                Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
                )
            }
            })

            });


            Livewire.on('deleteColorSize',pivot=>{
        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
        if (result.isConfirmed) {

            Livewire.emitTo('admin.color-size','delete',pivot);

            Swal.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'
            )
        }
        })
       });
    </script>

    @endpush

</div>
