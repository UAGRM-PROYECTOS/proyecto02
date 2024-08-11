<div class="space-y-6">
    <div>
        <x-input-label for="nombre" :value="__('Nombre')"/>
        <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre', $producto?->nombre)" autocomplete="nombre" placeholder="Nombre"/>
        <x-input-error class="mt-2" :messages="$errors->get('nombre')"/>
    </div>
    <div>
        <x-input-label for="descripcion" :value="__('Descripcion')"/>
        <x-text-input id="descripcion" name="descripcion" type="text" class="mt-1 block w-full" :value="old('descripcion', $producto?->descripcion)" autocomplete="descripcion" placeholder="Descripcion"/>
        <x-input-error class="mt-2" :messages="$errors->get('descripcion')"/>
    </div>
    <div>
        <x-input-label for="precio" :value="__('Precio')"/>
        <x-text-input id="precio" name="precio" type="text" class="mt-1 block w-full" :value="old('precio', $producto?->precio)" autocomplete="precio" placeholder="Por default 00.00"/>
        <x-input-error class="mt-2" :messages="$errors->get('precio')"/>
    </div>

    <input type="hidden" name="categoria_id" id="categoria_id_hidden" :value="old('categoria_id', $producto ? $producto->categoria_id : '')">
    <input type="hidden" name="unidad" id="unidad_hidden" :value="old('unidad', $producto ? $producto->unidad : '')">

    <!--mod form para add select mode -->
    <div class="flex justify-end gap-4">
        <div>
            <x-input-label for="unidad" :value="__('Unidad')"/>
            <select class="block mt-1 w-full rounded-lg" id="unidad" onchange="updateHiddenInput()">
                <option hidden selected>- SELECCIONE -</option>
                @foreach ($unidades as $unidad)
                    <option value="{{ $unidad }}" {{ old('unidad', $producto?->unidad) == $unidad ? 'selected' : '' }}>{{ $unidad }}</option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('unidad')"/>
        </div>

        <div>
            <x-input-label for="categoria_id" :value="__('Categoria')"/>
            <select class="block mt-1 w-full rounded-lg" id="categoria_id" onchange="updateHiddenInput()">
                <option hidden selected>- SELECCIONE -</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ old('categoria_id', $producto?->categoria_id) == $categoria->id ? 'selected' : '' }}>{{ $categoria->nombre }}</option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('categoria_id')"/>
        </div>
    </div>

    <div class="mt-5">
        <x-input-label for="foto" :value="__('Foto del producto')" />
        <x-text-input id="imagen" name="imagen" type="file" accept="image/*" class="mt-1 block w-full" onchange="previewImage(event)" />
        <img id="image-preview" style="display: none; margin-top: 10px;" class="max-w-full h-auto rounded-lg"/>
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>

<script>
    function updateHiddenInput() {
        var selectedCategoriaId = document.getElementById('categoria_id').value;
        document.getElementById('categoria_id_hidden').value = selectedCategoriaId;

        var selectedUnidad = document.getElementById('unidad').value;
        document.getElementById('unidad_hidden').value = selectedUnidad;
    }

    function previewImage(event) {
        const [file] = event.target.files;
        if (file) {
            const preview = document.getElementById('image-preview');
            preview.src = URL.createObjectURL(file);
            preview.onload = () => URL.revokeObjectURL(preview.src);
            preview.style.display = 'block';
        }
    }
</script>
