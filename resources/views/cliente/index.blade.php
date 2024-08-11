<x-app-layout>
    <x-slot name="header">
        <h2 :class="{ 'italic-font': isYoungMode }" class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de Usuarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Usarios') }}</h1>

                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">

                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <a type="button" href="{{ route('admins.create') }}"
                                class="block rounded-md bg-green-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"><i
                                    class="fa-solid fa-plus"></i>Agregar Administrativo</a>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <a type="button" href="{{ route('clientes.create') }}"
                                class="block rounded-md bg-green-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"><i
                                    class="fa-solid fa-plus"></i>Agregar Cliente</a>
                        </div>
                    </div>
                    <form method="GET" action="{{ route('clientes.index') }}">
                        <!-- Otros filtros como order_by y quantity_filter -->
                        <div class="flex gap-2">
                            <select name="user_role" id="user_role"
                                class="mt-1 block w-30 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                                <option value="">Todos los Usuarios</option>
                                <option value="cliente" {{ request('user_role') == 'cliente' ? 'selected' : '' }}>
                                    Clientes</option>
                                <option value="admin" {{ request('user_role') == 'admin' ? 'selected' : '' }}>
                                    Administradores</option>
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
                                            <th scope="col"
                                                class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                                No</th>

                                            <th scope="col"
                                                class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                                Nombre</th>
                                            <th scope="col"
                                                class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                                Email</th>
                                            <th scope="col"
                                                class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                                Direccion</th>
                                            <th scope="col"
                                                class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                                Telefono</th>

                                            <th scope="col"
                                                class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                        <?php
                                    $valor = 1;
                                    ?>
                                        @foreach ($clientes as $cliente)
                                        <tr class="even:bg-gray-50">
                                            <td
                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">
                                                {{ $valor++ }}</td>

                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ $cliente->name }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ $cliente->email }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ $cliente->direccion }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ $cliente->telefono }}</td>

                                            <td
                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                                                <form action="{{ route('clientes.destroy', $cliente->id) }}"
                                                    method="POST">
                                                    <a href="{{ route('clientes.show', $cliente->id) }}"
                                                        class="text-gray-600 font-bold hover:text-gray-900 mr-2"><i
                                                            class="fa-solid fa-eye"></i>{{ __('Ver') }}</a>
                                                    <a href="{{ route('clientes.edit', $cliente->id) }}"
                                                        class="text-green-600 font-bold hover:text-green-900  mr-2"><i
                                                            class="fa-solid fa-pen-to-square"></i>{{ __('Editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="{{ route('clientes.destroy', $cliente->id) }}"
                                                        class="text-red-600 font-bold hover:text-red-900"
                                                        onclick="event.preventDefault(); confirm('Esta seguro que quiere realizar la accion de eliminar?') ? this.closest('form').submit() : false;"><i
                                                            class="fa-solid fa-trash"></i>{{ __('Eliminar') }}</a>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-visits> {{$visits->cant}} </x-visits>
    </div>
</x-app-layout>