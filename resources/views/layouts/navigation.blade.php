<style>
    .italic-font {
        font-style: italic;
    }
</style>
<style>
    #searchResults {
        position: absolute;
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        top: 45px;
        width: 250px; /* Asegúrate de que el ancho sea adecuado */
    }

    #searchResults a {
        display: block;
        padding: 8px;
        text-decoration: none;
        color: #333;
    }

    #searchResults a:hover {
        background-color: #f0f0f0;
    }
</style>

<nav x-data="{ open: false, isDarkMode: $isDarkMode }" {{-- class="bg-white border-b border-gray-100"> --}}
    :class="{
        'bg-white border-b': !
            isChildMode,
        'border-b border-green-500 bg-yellow-500': isChildMode,
        'border-b border-blue-500 bg-red-500': isYoungMode,
    }">

    <!-- Primary Navigation Menu -->
    <div class="max-w-8xl mx-auto px-6 sm:px-8 lg:px-10">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center space-x-6">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                    <img src="https://res.cloudinary.com/drjvgyusx/image/upload/v1720578579/logo_jojjjr.jpg"style="width: 60px; height: 55px; margin-right: 2px;"/>
                    </a>

                    <!-- Botón para cambiar de modo -->
                    <button style="margin-right: 10px;"
                        @click="isChildMode = !isChildMode; localStorage.setItem('isChildMode', isChildMode); localStorage.setItem('isYoungMode', false)"
                        :class="{
                            'bg-gray-200 border-b dark:bg-gray-800': !
                                isChildMode,
                            'border border-green-500 text-red-500 bg-orange-500': isChildMode,
                            'border border-red-500 text-blue-500 bg-black': isYoungMode,
                        }"
                        class="mx-2 p-2 rounded ">
                        <i class="fa-solid fa-child"></i>
                    </button>

                    <button style="margin-right: 10px;"
                        @click="isYoungMode = !isYoungMode; localStorage.setItem('isYoungMode', isYoungMode)"
                        :class="{
                            'bg-gray-200 border-b dark:bg-gray-800': !
                                isChildMode,
                            'border border-green-500 text-red-500 bg-orange-500': isChildMode,
                            'border border-red-500 text-blue-500 bg-black': isYoungMode,
                        }"
                        class="mx-2 p-2 rounded">
                        <i class="fa-solid fa-person"></i>
                    </button>
                    <button
                        @click="isDarkMode = !isDarkMode; localStorage.setItem('theme', isDarkMode ? 'dark' : 'light')"
                        :class="{
                            'bg-gray-200 border-b dark:bg-gray-800': !
                                isChildMode,
                            'border border-green-500 text-red-500 bg-orange-500': isChildMode,
                            'border border-red-500 text-blue-500 bg-black': isYoungMode,
                        }"
                        class="p-2 rounded">
                        <i :class="isDarkMode ? 'fas fa-sun' : 'fas fa-moon'"></i>
                    </button>
                </div>
                @if(auth()->user()->can('administrar usuarios'))
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <div :class="{ 'italic-font': isYoungMode }">
                            {{ __('Dashboard') }}
                        </div>
                    </x-nav-link>
                </div>
                @endif
                @if(auth()->user()->can('administrar productos'))
                <!-- Settings Dropdown-Productos -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div :class="{ 'italic-font': isYoungMode }">Mis Productos</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <i :class="isChildMode ? 'fa-solid fa-carrot' : ''"></i>

                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('productos.index')" :active="request()->routeIs('productos.index')">
                                {{ __('Productos') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('ingresos.index')" :active="request()->routeIs('ingresos.index')">
                                {{ __('Ingresos') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('salidas.index')" :active="request()->routeIs('salidas.index')">
                                {{ __('Salidas') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('inventarios.index')" :active="request()->routeIs('inventarios.index')">
                                {{ __('Inventario') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>
                @endif
                <!----------------------------------------------------------------->
                @if(auth()->user()->can('administrar usuarios'))
                <!-- Settings Dropdown-Clientes -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button :class="{ 'italic-font': isYoungMode }"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ __('Mis Usuarios') }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <i :class="isChildMode ? 'fa-solid fa-people-group' : ''"></i>

                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('clientes.index')" :active="request()->routeIs('clientes.index')">
                                {{ __('Usuarios') }}
                            </x-dropdown-link>

                        </x-slot>
                    </x-dropdown>
                </div>
                @endif
                <!----------------------------------------------------------------->
                <!-- Settings Dropdown-Ordenes -->
                <div class="hidden sm:flex sm:items-center sm:ms-4" style="margin-right: 20px;">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div :class="{ 'italic-font': isYoungMode }">{{ __('Mis pedidos') }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <i :class="isChildMode ? 'fa-solid fa-store' : ''"></i>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('producto.catalogo')"
                                :active="request()->routeIs('producto.catalogo')">
                                {{ __('Catalogo') }}
                            </x-dropdown-link>
                            @if(auth()->user()->can('ver pedidos'))
                            <x-dropdown-link :href="route('pedidos.pedidos')" :active="request()->routeIs('ordens.index')">
                                {{ __('Pedidos') }}
                            </x-dropdown-link>
                            @endif
                            @if(auth()->user()->can('administrar ordens'))
                            <x-dropdown-link :href="route('ordens.index')" :active="request()->routeIs('ordens.index')">
                                {{ __('Ordenes') }}
                            </x-dropdown-link>
                            @endif
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Search Bar -->
                <div class="flex items-center ms-10" style="margin-right: 20px;">
                    <input type="text" id="searchInput" name="query" placeholder="Buscar..."
                        class="border rounded-md p-2 text-sm focus:outline-none focus:ring focus:border-blue-300"
                        style="width: 250px;">
                    <button type="button" class="p-2 ml-2 text-white bg-blue-500 rounded-md hover:bg-blue-700 focus:outline-none">
                        <i class="fas fa-search"></i>
                    </button>
                    <div id="searchResults" class="absolute bg-white border mt-2 w-250 hidden"></div>
                </div>

                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const searchInput = document.getElementById('searchInput');
                    const searchResults = document.getElementById('searchResults');

                    searchInput.addEventListener('input', function() {
                        const query = searchInput.value;

                        if (query.length > 1) { // Solo realiza la búsqueda si el query tiene más de 1 caracter
                            fetch(`/productos/search?query=${query}`)
                                .then(response => response.json())
                                .then(data => {
                                    if (data.length > 0) {
                                        searchResults.innerHTML = data.map(producto => `
                                            <a href="/productos/${producto.id}" class="block p-2 hover:bg-gray-200">
                                                ${producto.nombre}
                                            </a>
                                        `).join('');
                                        searchResults.classList.remove('hidden');
                                    } else {
                                        searchResults.innerHTML = '<p class="p-2">No se encontraron resultados.</p>';
                                        searchResults.classList.remove('hidden');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error fetching search results:', error);
                                });
                        } else {
                            searchResults.classList.add('hidden');
                        }
                    });

                    // Cerrar resultados al hacer clic fuera del área de búsqueda
                    document.addEventListener('click', function(event) {
                        if (!searchResults.contains(event.target) && event.target !== searchInput) {
                            searchResults.classList.add('hidden');
                        }
                    });
                });
                </script>
                    <!-- Hamburger -->
                <div class="me-2 sm:flex sm:items-center sm:ms-6">
                    <button onclick="window.location='{{ route('detalle-ordens.index') }}'" class="inline-flex items-center justify-center p-2 rounded-md bg-black hover:bg-grey-800 text-white font-bold py-2 px-4 rounded">
                        <x-car></x-car>
                    </button>

                </div>                
            </div>
            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                         <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div :class="{ 'italic-font': isYoungMode }">{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
