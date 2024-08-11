<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Ordenes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Ordenes') }}</h1>
                            <p class="mt-2 text-sm text-gray-700">Lista de {{ __('Ordenes') }}.</p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">

                        </div>
                    </div>
                    <form method="GET" action="{{ route('pedidos.pedidos') }}">
                        <!-- Otros filtros como order_by y quantity_filter -->
                        <div class="flex gap-2">
                            <select name="estado" id="estado"
                                class="mt-1 block w-30 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                                <option value="">Todos las Ordenes</option>
                                <option value="PEDIDO" {{ request('estado') == 'PEDIDO' ? 'selected' : '' }}>
                                    Pedidos</option>
                                <option value="PAGADO" {{ request('estado') == 'PAGADO' ? 'selected' : '' }}>
                                    Pagados</option>
                                    <option value="ENVIADO" {{ request('estado') == 'ENVIADO' ? 'selected' : '' }}>
                                    Enviados</option>
                                    <option value="ANULADO" {{ request('estado') == 'ANULADO' ? 'selected' : '' }}>
                                    Anulados</option>
                            </select>

                            <div class="flex items-end">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Filtrar</button>
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
                                        
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Cliente</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Estado</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Total</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Fecha</th>

                                        <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500"></th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach ($ordens as $orden)
                                        <tr class="even:bg-gray-50">
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">{{ ++$i }}</td>
                                            
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $orden->user->name }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $orden->estado->nombre }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $orden->total }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $orden->fecha }}</td>

                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                                                <form action="{{ route('ordens.destroy', $orden->id) }}" method="POST">
                                                    <a href="{{ route('orden.ver', $orden->id) }}" class="text-gray-600 font-bold hover:text-gray-900 mr-2"><i class="fa-solid fa-eye"></i>{{ __('Ver') }}</a>
                                                   
                                                   
                                                    @csrf
                                                    @method('DELETE')
                                                    
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                <div class="mt-4 px-4">
                                    {!! $ordens->withQueryString()->links() !!}
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