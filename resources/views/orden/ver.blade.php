<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-gray-100 p-4 rounded-md shadow-md">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $orden ? __('Orden de Compra') : __('Orden Vacía') }}
                </h2>
                @if($orden)
                <p class="text-sm text-gray-600">{{ __('Estado: ') }}<span class="font-bold">{{ $orden->estado->nombre ?? __('Estado Desconocido') }}</span></p>
                    <p class="text-sm text-gray-600">{{ __('Cliente: ') }}<span class="font-bold">{{ $orden->user->name ?? __('Cliente Desconocido') }}</span></p>
                    <p class="text-sm text-gray-600">{{ __('Total: ') }}<span class="font-bold">{{ $orden->total ?? __('No disponible') }}</span></p>
                @endif
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <a type="button" href="javascript:history.back()" class="block rounded-md bg-green-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">

                    <!-- Order Items Table -->
                    @if($orden && !$detalleOrdens->isEmpty())
                        <div class="flow-root mt-8">
                            <div class="overflow-x-auto">
                                <table class="w-full divide-y divide-gray-300">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">#</th>
                                        <th scope="col" class="py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Producto</th>
                                        <th scope="col" class="py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Cantidad</th>
                                        <th scope="col" class="py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Precio Unitario</th>
                                        <th scope="col" class="py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Precio Total</th>
                                        <th scope="col" class="py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500"></th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach ($detalleOrdens as $index => $detalleOrden)
                                        <tr class="even:bg-gray-50">
                                            <td class="whitespace-nowrap py-4 text-center text-sm font-semibold text-gray-900">{{ $index + 1 }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-800 flex items-center">
                                                <img src="{{ $detalleOrden->producto->imagen }}" alt="{{ $detalleOrden->producto->nombre }}" class="h-20 w-20 object-cover mr-6 rounded-md border border-gray-300">
                                                <div class="flex flex-col">
                                                    <span class="font-medium">{{ $detalleOrden->producto->nombre }}</span>
                                                    <span class="text-gray-500 text-xs">{{ $detalleOrden->producto->descripcion }}</span>
                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-800 text-center">
                                               
                                                  {{ $detalleOrden->cantidad }}
                                   
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-800 text-center">{{ $detalleOrden->precio_unitario }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-800 text-center">{{ $detalleOrden->precio_total }}</td>
                                            <td class="whitespace-nowrap py-4 text-center text-sm font-medium">
                       
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                <div class="mt-4 px-4">
                                    {!! $detalleOrdens->withQueryString()->links() !!}
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="mt-8 p-4 bg-yellow-100 border border-yellow-300 rounded-md">
                            <p class="text-sm text-gray-800">{{ __('No tienes productos en tu orden.') }}</p>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    @if($orden)
                        <div class="sm:flex sm:items-center justify-between mt-8">
                            <div></div>

                        </div>
                    @endif

                </div>
            </div>
        </div>
        <x-visits>{{$visits->cant}} </x-visits>
    </div>
</x-app-layout>
