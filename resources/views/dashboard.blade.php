<x-app-layout>
    <style>
    .italic-font {
        font-style: italic;
    }


    .body-carousel {
        display: flex;

        align-items: center;
        justify-content: center;
    }

    .wrapper-tecnicos {
        max-width: 1100px;
        width: 100%;
        position: relative;
    }

    .wrapper-tecnicos i {
        top: 50%;
        height: 50px;
        width: 50px;
        cursor: pointer;
        font-size: 1.25rem;
        position: absolute;
        text-align: center;
        line-height: 50px;
        background: #fff;
        border-radius: 50%;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.23);
        transform: translateY(-50%);
        transition: transform 0.1s linear;
    }

    .wrapper-tecnicos i:active {
        transform: translateY(-50%) scale(0.85);
    }

    .wrapper-tecnicos i:first-child {
        left: -22px;
    }

    .wrapper-tecnicos i:last-child {
        right: -22px;
    }

    .wrapper-tecnicos .carousel {
        padding: 50px 0;
        display: grid;
        grid-auto-flow: column;
        grid-auto-columns: calc((100% / 3) - 12px);
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        gap: 16px;
        border-radius: 8px;
        scroll-behavior: smooth;
        scrollbar-width: none;
    }

    .carousel::-webkit-scrollbar {
        display: none;
    }

    .carousel.no-transition {
        scroll-behavior: auto;
    }

    .carousel.dragging {
        scroll-snap-type: none;
        scroll-behavior: auto;
    }

    .carousel.dragging .card {
        cursor: grab;
        user-select: none;
    }

    .carousel :where(.card, .img) {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .carousel .card {
        scroll-snap-align: center;
        height: 342px;
        /* width: 70%; */
        list-style: none;
        background: #fff;
        cursor: pointer;
        padding-bottom: 15px;
        flex-direction: column;
        border-radius: 8px;
    }

    .carousel .card .img {
        background: #04527b;
        height: 148px;
        width: 148px;
        border-radius: 50%;
    }

    .card .img img {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #fff;
    }

    .carousel .card h2 {
        font-weight: 500;
        font-size: 1.56rem;
        margin: 30px 0 5px;
    }

    .carousel .card span {
        color: #6A6D78;
        font-size: 1.31rem;
    }

    .card h2,
    .card span {
        text-align: center;
    }

    @media screen and (max-width: 900px) {
        .wrapper-tecnicos .carousel {
            grid-auto-columns: calc((100% / 2) - 9px);
        }
    }

    @media screen and (max-width: 600px) {
        .wrapper-tecnicos .carousel {
            grid-auto-columns: 100%;
        }
    }
    </style>
    <x-slot name="header">
        <div :class="{ 'border border-green-500': isChildMode, }">
            <h2 :class="{ 'border border-green-500 text-red-500 bg-blue-500': isChildMode, 'border  text-blue-500 italic-font': isYoungMode, }"
                class="font-semibold text-xl  leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>

    </x-slot>
    <section :class="{ 'hidden': !isYoungMode }" id="equipo">

        <div class="body-carousel">

            <div class="wrapper-tecnicos">
                <i id="left" class="fa-solid fa-angle-left"></i>
                <ul class="carousel">
                    <li class="card">
                        <img src="{{ asset('img/img1.jpeg') }}" alt="">
                    </li>
                    <li class="card">
                        <img src="{{ asset('img/img2.jpeg') }}" alt="">
                    </li>
                    <li class="card">
                        <img src="{{ asset('img/img3.jpeg') }}" alt="">
                    </li>
                    <li class="card">
                        <img src="{{ asset('img/img4.jpeg') }}" alt="">
                    </li>
                    <li class="card">
                        <img src="{{ asset('img/img5.jpg') }}" alt="">
                    </li>
                    <li class="card">
                        <img src="{{ asset('img/img6.jpg') }}" alt="">
                    </li>


                    {{-- <li class="card">
                <div class="img"><img src="img/img-1.jpg" alt="img" draggable="false"></div>
                <h2>Sra. Karen Garcia Escobar</h2>
                <span>Secretaria - S.D.E.R</span>
            </li> --}}
                </ul>
                <i id="right" class="fa-solid fa-angle-right"></i>
            </div>

        </div>
    </section>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <h3 class="font-semibold text-lg mb-6">KPI</h3>
                    
                    <div class="mb-10">
                        <a href="{{ route('reporte.inventario') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Generar Reporte de Inventario
                        </a>
                        <a href="{{ route('reporte.producto') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-4">
                            Generar Reporte de Producto
                        </a>
                    </div>
                    <div class="flex gap-2">
                        <div class="bg-green-200 mt-5 p-3 rounded-lg flex flex-col justify-center">
                            <p class="font-bold">Cantidad de Productos vendidos: <span
                                    class="font-normal">{{$cantProdVendidos ?? 'N/A'}}</span>
                            </p>
                            <!-- <p>Vendida: <span>{{$pizzaMasVendida['total_pedidos'] ?? '0'}}</span>
                                                    veces</p>-->
                        </div>
                        <div class="bg-red-200 mt-5 p-3 rounded-lg flex flex-col justify-center">
                            <p class="font-bold">Cantidad de ventas obtenidads: <span
                                    class="font-normal">{{$cantVentasObtenidas ?? 'N/A'}}</span>
                            </p>
                            <!--<p>Vendida: <span>{{$pizzaMenosVendida['total_pedidos'] ?? '0'}}</span>
                                                    veces</p>-->
                        </div>
                        <div class="bg-blue-200 mt-5 p-3 rounded-lg">
                            <p class="font-bold">Cantidad de usuarios: <span class="font-normal">{{$cantUser}}</span>
                            </p>
                            <p>Cantidad de clientes: <span>{{$cantClientes}}</span></p>
                            <p>Cantidad de administradores: <span>{{$cantAdmin}}</span></p>
                        </div>
                        <div class="bg-yellow-200 mt-5 p-3 rounded-lg flex flex-col justify-center">
                            <p class="font-bold">Cantidad Total en Bs por ventas: <span
                                    class="font-normal">{{$cantidadTotalVentas ?? 'N/A'}}</span>
                            </p>
                            <!--<p>Vendida: <span>{{$pizzaMenosVendida['total_pedidos'] ?? '0'}}</span>
                                                    veces</p>-->
                        </div>
                    </div>
                    <div class="flex flex-wrap">

                        <div class="w-full md:w-1/2 p-3">
                            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                                <h3 class="font-semibold text-lg p-4">
                                    {{$pedidos_month_chart->options['chart_title']}}
                                </h3>
                                <div class="p-4">
                                    {!! $pedidos_month_chart->renderHtml() !!}
                                    {!! $pedidos_month_chart->renderChartJsLibrary() !!}
                                    {!! $pedidos_month_chart->renderJs() !!}
                                </div>
                            </div>
                        </div>
                        <!-- Gráfico de productos cercanos al stock mínimo 
                        <div class="w-full md:w-1/2 p-3">
                            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                                <h3 class="font-semibold text-lg p-4">
                                    {{$ventas_por_categoria_chart->options['chart_title']}}
                                </h3>
                                <div class="p-4">
                                    {!! $ventas_por_categoria_chart->renderHtml() !!}
                                    {!! $ventas_por_categoria_chart->renderChartJsLibrary() !!}
                                    {!! $ventas_por_categoria_chart->renderJs() !!}
                                </div>
                            </div>
                        </div>
-->
                        <div class="w-full md:w-1/2 p-3">
                            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                                <h3 class="font-semibold text-lg p-4">
                                    {{$productos_chart_instance->options['chart_title']}}
                                </h3>
                                <div class="p-8">
                                    {!! $productos_chart_instance->renderHtml() !!}
                                    {!! $productos_chart_instance->renderChartJsLibrary() !!}
                                    {!! $productos_chart_instance->renderJs() !!}
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>


    <x-visits> {{$visits->cant}} </x-visits>
    @section('scripts')
    {!! $user_month_chart->renderChartJsLibrary() !!}
    {!! $user_month_chart->renderJs() !!}
    {!! $pedidos_month_chart->renderChartJsLibrary() !!}
    {!! $pedidos_month_chart->renderJs() !!}
    {!! $productos_chart_instance->renderChartJsLibrary() !!}
    {!! $productos_chart_instance->renderJs() !!}
    {!! $ventas_por_categoria_chart->renderChartJsLibrary() !!}
    {!! $ventas_por_categoria_chart->renderJs() !!}
    </script>
    @endsection



</x-app-layout>