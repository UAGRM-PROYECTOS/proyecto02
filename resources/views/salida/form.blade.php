<div class="space-y-6">
    
    <div>
        <x-input-label for="orden_id" :value="__('Orden Id')"/>
        <x-text-input id="orden_id" name="orden_id" type="hidden" class="mt-1 block w-full" :value="old('orden_id', $salida?->id)" autocomplete="orden_id" placeholder="Orden Id"/>
        <x-input-error class="mt-2" :messages="$errors->get('orden_id')"/>
    </div>


<!--mod form para add select mode -->
<div>
        <x-input-label for="fecha" :value="__('Seleccione un Estado')" />
        <select class="block mt-1 w-full rounded-lg" wire:model="estado_id" id="estado_id"
            onchange="updateHiddenInput2()">
            <option hidden selected>- SELECCIONE -</option>
            @foreach ($estados as $estado)
            <option value="{{$estado->id}}" data-nombre="{{$estado->nombre}}">{{$estado->nombre}}</option>
            @endforeach
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('fecha')" />
    </div>
    <div>
        <x-input-label for="estado_id" :value="__('Estado')"/>
        <x-text-input id="estado_id" name="estado_id" type="text" class="mt-1 block w-full" :value="old('estado_id', $salida?->estado_id)" autocomplete="estado_id" placeholder="Estado Id"/>
        <x-input-error class="mt-2" :messages="$errors->get('estado_id')"/>
    </div>

    <script>
    function updateHiddenInput2() {
        var selectedEstadoId = document.getElementById('estado_id').value;
        document.getElementById('estado_id_hidden').value = selectedEstadoId;

        var selectedOption = document.getElementById('estado_id').options[document.getElementById('estado_id').selectedIndex];
        var dataname = selectedOption.getAttribute('data-nombre');
        document.getElementById('estado_name').value = dataname;

    }
    </script>
    <!-- end select-->

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>