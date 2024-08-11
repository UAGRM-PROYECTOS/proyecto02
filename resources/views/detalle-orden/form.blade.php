<div class="space-y-6">
    
    <div>
        <x-input-label for="producto_id" :value="__('Producto Id')"/>
        <x-text-input id="producto_id" name="producto_id" type="text" class="mt-1 block w-full" :value="old('producto_id', $detalleOrden?->producto_id)" autocomplete="producto_id" placeholder="Producto Id"/>
        <x-input-error class="mt-2" :messages="$errors->get('producto_id')"/>
    </div>
    <div>
        <x-input-label for="orden_id" :value="__('Orden Id')"/>
        <x-text-input id="orden_id" name="orden_id" type="text" class="mt-1 block w-full" :value="old('orden_id', $detalleOrden?->orden_id)" autocomplete="orden_id" placeholder="Orden Id"/>
        <x-input-error class="mt-2" :messages="$errors->get('orden_id')"/>
    </div>
    <div>
        <x-input-label for="cantidad" :value="__('Cantidad')"/>
        <x-text-input id="cantidad" name="cantidad" type="text" class="mt-1 block w-full" :value="old('cantidad', $detalleOrden?->cantidad)" autocomplete="cantidad" placeholder="Cantidad"/>
        <x-input-error class="mt-2" :messages="$errors->get('cantidad')"/>
    </div>
    <div>
        <x-input-label for="precio_unitario" :value="__('Precio Unitario')"/>
        <x-text-input id="precio_unitario" name="precio_unitario" type="text" class="mt-1 block w-full" :value="old('precio_unitario', $detalleOrden?->precio_unitario)" autocomplete="precio_unitario" placeholder="Precio Unitario"/>
        <x-input-error class="mt-2" :messages="$errors->get('precio_unitario')"/>
    </div>
    <div>
        <x-input-label for="precio_total" :value="__('Precio Total')"/>
        <x-text-input id="precio_total" name="precio_total" type="text" class="mt-1 block w-full" :value="old('precio_total', $detalleOrden?->precio_total)" autocomplete="precio_total" placeholder="Precio Total"/>
        <x-input-error class="mt-2" :messages="$errors->get('precio_total')"/>
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>