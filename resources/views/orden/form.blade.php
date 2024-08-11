<div class="space-y-6">
    <!--------------------------------------------------------------------------------->
    <div>
        <x-input-label for="cliente" :value="__('Elija un Cliente')" />
        <select class="block mt-1 w-full rounded-lg" wire:model="cliente_id" id="cliente_id_select" onchange="updateHiddenInput1()">
            <option hidden selected>- SELECCIONE -</option>
            @foreach ($clientes as $cliente)
                <option value="{{ $cliente->id }}" data-nombre="{{ $cliente->name }}" {{ old('cliente_id', $orden?->cliente_id) == $cliente->id ? 'selected' : '' }}>{{ $cliente->name }}</option>
            @endforeach
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('cliente_id')" />
    </div>

    <input type="hidden" name="cliente_id" id="cliente_id_hidden" value="{{ old('cliente_id', $orden ? $orden->cliente_id : '') }}">

    <!------------------------------------------------------------------------->
    <div>
        <x-input-label for="fecha" :value="__('Fecha')" />
        <x-text-input id="fecha" name="fecha" type="datetime-local" class="mt-1 block w-full" :value="old('fecha', $orden?->fecha)" autocomplete="fecha" placeholder="Fecha" />
        <x-input-error class="mt-2" :messages="$errors->get('fecha')" />
    </div>

    <!--mod form para add select mode -->
    <div>
        <x-input-label for="estado" :value="__('Seleccione un Estado')" />
        <select class="block mt-1 w-full rounded-lg" wire:model="estado_id" id="estado_id" onchange="updateHiddenInput2()">
            <option hidden selected>- SELECCIONE -</option>
            @foreach ($estados as $estado)
                <option value="{{ $estado->id }}" data-nombre="{{ $estado->nombre }}" {{ old('estado_id', $orden?->estado_id) == $estado->id ? 'selected' : '' }}>{{ $estado->nombre }}</option>
            @endforeach
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('estado_id')" />
    </div>


    <input type="hidden" name="estado_id" id="estado_id_hidden" value="{{ old('estado_id', $orden ? $orden->estado_id : '') }}">

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>

<script>
    function updateHiddenInput1() {
        var selectedClienteId = document.getElementById('cliente_id_select').value;
        document.getElementById('cliente_id_hidden').value = selectedClienteId;

        var selectedOption = document.getElementById('cliente_id_select').options[document.getElementById('cliente_id_select').selectedIndex];
        var dataname = selectedOption.getAttribute('data-nombre');
        document.getElementById('cliente_name').value = dataname;
    }

    function updateHiddenInput2() {
        var selectedEstadoId = document.getElementById('estado_id').value;
        document.getElementById('estado_id_hidden').value = selectedEstadoId;

        var selectedOption = document.getElementById('estado_id').options[document.getElementById('estado_id').selectedIndex];
        var dataname = selectedOption.getAttribute('data-nombre');
        document.getElementById('estado_name').value = dataname;
    }
</script>
