<div class="space-y-6">
    
    <div>
        <x-input-label for="producto_id" :value="__('Producto Id')"/>
        <x-text-input id="producto_id" name="producto_id" type="text" class="mt-1 block w-full" :value="old('producto_id', $inventario?->producto_id)" autocomplete="producto_id" placeholder="Producto Id"/>
        <x-input-error class="mt-2" :messages="$errors->get('producto_id')"/>
    </div>
    <div>
        <x-input-label for="cantidad" :value="__('Cantidad')"/>
        <x-text-input id="cantidad" name="cantidad" type="text" class="mt-1 block w-full" :value="old('cantidad', $inventario?->cantidad)" autocomplete="cantidad" placeholder="Cantidad"/>
        <x-input-error class="mt-2" :messages="$errors->get('cantidad')"/>
    </div>
    <div>
        <x-input-label for="costo_unitario" :value="__('Costo Unitario')"/>
        <x-text-input id="costo_unitario" name="costo_unitario" type="text" class="mt-1 block w-full" :value="old('costo_unitario', $inventario?->costo_unitario)" autocomplete="costo_unitario" placeholder="Costo Unitario"/>
        <x-input-error class="mt-2" :messages="$errors->get('costo_unitario')"/>
    </div>
    <div>
        <x-input-label for="fecha_ingreso" :value="__('Fecha Ingreso')"/>
        <x-text-input id="fecha_ingreso" name="fecha_ingreso" type="text" class="mt-1 block w-full" :value="old('fecha_ingreso', $inventario?->fecha_ingreso)" autocomplete="fecha_ingreso" placeholder="Fecha Ingreso"/>
        <x-input-error class="mt-2" :messages="$errors->get('fecha_ingreso')"/>
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>