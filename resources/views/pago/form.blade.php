<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Columna Izquierda -->
                            <div class="space-y-6">
                                <!-- Datos del Cliente -->
                                <div>
                                    <x-input-label for="tcRazonSocial" :value="__('Razón Social')"/>
                                    <x-text-input id="tcRazonSocial" name="tcRazonSocial" type="text" class="mt-1 block w-full" :value="old('tcRazonSocial', $cliente->name)" placeholder="Nombre del Usuario"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('tcRazonSocial')"/>
                                </div>

                                <div>
                                    <x-input-label for="tcCiNit" :value="__('CI/NIT')"/>
                                    <x-text-input id="tcCiNit" name="tcCiNit" type="text" class="mt-1 block w-full" :value="old('tcCiNit', $cliente->ci_nit)" placeholder="Número de CI/NIT"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('tcCiNit')"/>
                                </div>

                                <div>
                                    <x-input-label for="tnTelefono" :value="__('Celular')"/>
                                    <x-text-input id="tnTelefono" name="tnTelefono" type="text" class="mt-1 block w-full" :value="old('tnTelefono', $cliente->telefono)" placeholder="Número de Teléfono"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('tnTelefono')"/>
                                </div>

                                <div>
                                    <x-input-label for="tcCorreo" :value="__('Correo')"/>
                                    <x-text-input id="tcCorreo" name="tcCorreo" type="text" class="mt-1 block w-full" :value="old('tcCorreo', $cliente->email)" placeholder="Correo Electrónico"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('tcCorreo')"/>
                                </div>

                                <div>
                                    <x-input-label for="tnMonto" :value="__('Monto Total')"/>
                                    <x-text-input id="tnMonto" name="tnMonto" type="text" class="mt-1 block w-full" :value="old('tnMonto', $orden->total)" placeholder="Costo Total"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('tnMonto')"/>
                                </div>

                                <div>
                                    <x-input-label for="tnTipoServicio" :value="__('Tipo de Servicio')"/>
                                    <select id="tnTipoServicio" name="tnTipoServicio" class="mt-1 block w-full rounded-md border-gray-300">
                                        <option value="1">Servicio QR</option>
                                        <option value="2">Tigo Money</option>
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('tnTipoServicio')"/>
                                </div>
                            </div>

                            <!-- Columna Derecha: Imagen QR -->
                            <div class="flex justify-center items-center">
    <iframe name="QrImage" class="w-full h-[32rem] max-h-[32rem] border rounded-md shadow-lg"></iframe>
</div>

                        </div>

                       

                        <!-- Botón de Envío -->
                        <div class="flex items-center justify-center mt-6">
                            <x-primary-button class="px-6 py-2">
                                Consumir
                            </x-primary-button>
                        </div>