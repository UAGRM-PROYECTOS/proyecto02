<x-app-layout>
    <x-slot name="header">
        <h2 
        :class="{ 'italic-font': isYoungMode }"
        class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inventario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-base font-semibold leading-6 text-gray-900">Lista del {{ __('Inventario') }}</h1>
                            
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <a type="button" href="{{ route('dashboard') }}" class="block rounded-md bg-green-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"><i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <!-- Filtros -->
                    <form method="GET" action="{{ route('inventarios.index') }}" class="mb-4">
                        <div class="flex gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Ordenar por Fecha de Ingreso</label>
                                <select name="order_by" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                                    <option value="">Seleccionar Orden</option>
                                    <option value="asc" {{ request('order_by') == 'asc' ? 'selected' : '' }}>Ascendente</option>
                                    <option value="desc" {{ request('order_by') == 'desc' ? 'selected' : '' }}>Descendente</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Filtrar por Cantidad</label>
                                <div class="mt-1 flex gap-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="quantity_filter" value="" {{ request('quantity_filter') == '' ? 'checked' : '' }} class="form-radio text-green-500 focus:ring-green-500">
                                        <span class="ml-2">Todos</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="quantity_filter" value="zero" {{ request('quantity_filter') == 'zero' ? 'checked' : '' }} class="form-radio text-green-500 focus:ring-green-500">
                                        <span class="ml-2">Cantidad 0</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="quantity_filter" value="low" {{ request('quantity_filter') == 'low' ? 'checked' : '' }} class="form-radio text-green-500 focus:ring-green-500">
                                        <span class="ml-2">Cantidad ≤ 5</span>
                                    </label>
                                </div>
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Aplicar Filtros</button>
                            </div>
                        </div>
                    </form>

                    <div class="flow-root">
                        <div class="mt-8 overflow-x-auto">
                            <div class="inline-block min-w-full py-2 align-middle">
                                <table class="w-full divide-y divide-gray-300">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">No</th>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Producto Id</th>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Cantidad Ingresada</th>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Cantidad Actual</th>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Costo Unitario</th>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Fecha Ingreso</th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach ($inventarios as $inventario)
                                        <tr class="even:bg-gray-50">
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">{{ ++$i }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $inventario->producto->nombre }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $inventario->cantidad_ingresada }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $inventario->cantidad_actual }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $inventario->costo_unitario }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $inventario->fecha_ingreso }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                <div class="mt-4 px-4">
                                    {!! $inventarios->withQueryString()->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-visits>{{$visits->cant}} </x-visits>
    </div>
</x-app-layout>
