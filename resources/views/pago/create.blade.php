<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Realizar el') }} Pago
        </h2>
    </x-slot>

    <div class="py-12 flex justify-center">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6 w-full md:w-2/3">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">
                    <!-- Mostrar mensajes de éxito o error -->
                    @if (session('success'))
                        <div class="mt-4 p-4 bg-green-100 border border-green-300 rounded-md">
                            <p class="text-green-800">{{ session('success') }}</p>
                            @if (session('transaccion'))
                                <p class="text-green-800">Transacción: {{ session('transaccion') }}</p>
                            @endif
                            @if (session('qrImage'))
                                <img src="{{ session('qrImage') }}" alt="QR Code" class="w-64 h-64">
                            @endif
                        </div>
                    @elseif (session('error'))
                        <div class="mt-4 p-4 bg-red-100 border border-red-300 rounded-md">
                            <p class="text-red-800">{{ session('error') }}</p>
                        </div>
                    @endif

                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-base font-semibold leading-6 text-gray-900"> Orden: {{ $orden->id }} </h1>
                            <h3>PagoFacil QR y Tigo Money</h3>
                            <p class="mt-2 text-sm text-gray-700">Agregar {{ __('Pago') }}.</p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <a type="button" href="{{ route('producto.catalogo') }}" class="block rounded-md bg-green-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-green-500">Ir a Catalogo</a>
                        </div>
                    </div>

                    <div class="flow-root">
                        <div class="mt-8 overflow-x-auto">
                            <form method="POST" action="{{ route('pago.consumirservicio') }}" role="form" enctype="multipart/form-data" target="QrImage">
                                @csrf
                                <input type="hidden" name="orden_id" value="{{ $orden->id }}">
                                @include('pago.form')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-visits>{{$visits->cant}} </x-visits>
    </div>
</x-app-layout>
