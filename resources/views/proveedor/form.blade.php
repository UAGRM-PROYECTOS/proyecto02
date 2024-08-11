<div class="space-y-6">
    
    <div>
        <x-input-label for="name" :value="__('Nombre')"/>
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $proveedor?->name)" autocomplete="name" placeholder="Nombre"/>
        <x-input-error class="mt-2" :messages="$errors->get('name')"/>
    </div>
    <div>
        <x-input-label for="email" :value="__('Email')"/>
        <x-text-input id="email" name="email" type="text" class="mt-1 block w-full" :value="old('email', $proveedor?->email)" autocomplete="email" placeholder="Email"/>
        <x-input-error class="mt-2" :messages="$errors->get('email')"/>
    </div>
    <div>
        <x-input-label for="direccion" :value="__('Direccion')"/>
        <x-text-input id="direccion" name="direccion" type="text" class="mt-1 block w-full" :value="old('direccion', $proveedor?->direccion)" autocomplete="direccion" placeholder="Direccion"/>
        <x-input-error class="mt-2" :messages="$errors->get('direccion')"/>
    </div>
    <div>
        <x-input-label for="telefono" :value="__('Telefono')"/>
        <x-text-input id="telefono" name="telefono" type="text" class="mt-1 block w-full" :value="old('telefono', $proveedor?->telefono)" autocomplete="telefono" placeholder="Telefono"/>
        <x-input-error class="mt-2" :messages="$errors->get('telefono')"/>
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>