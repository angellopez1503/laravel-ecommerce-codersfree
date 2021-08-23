<div class="container py-12">
    <x-jet-form-section submit="save" class="mb-6">
        <x-slot name="title">
            Agregar un  nuevo departmento
        </x-slot>

        <x-slot name="description">
            Complete la informacion necesaria para poder agregar un nuevo departmento
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label>
                    Nombre
                </x-jet-label>
                <x-jet-input  wire:model="createForm.name" type="text" class="w-full mt-1" ></x-jet-input>
                <x-jet-input-error for="createForm.name" ></x-jet-input-error>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message  class="mr-3" on="saved">
                Departamento  agregado
            </x-jet-action-message>
            <x-jet-button>
                Agregar
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>
</div>
