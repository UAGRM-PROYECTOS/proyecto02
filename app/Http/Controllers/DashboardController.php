<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\DetalleOrden;
use App\Models\Orden;
use App\Models\Producto;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class DashboardController extends Controller
{
    public function index()
    {
        $cantUser = User::count();
        $cantAdmin = User::role('admin')->get()->count();
        $cantClientes = User::role('cliente')->get()->count();
        $visits = Visit::where(['page_name' => 'dashboard'])->first();

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $cantProdVendidos = DetalleOrden::whereHas('orden', function ($query) use ($startOfMonth, $endOfMonth) {
            $query->where('estado_id', 8) 
                  ->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
        })
        ->sum('cantidad');
        
        

        $cantVentasObtenidas = Orden::where('estado_id', 8) 
        ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
        ->count();

        $cantidadTotalVentas = Orden::where('estado_id', 8) 
        ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
        ->sum('total');


        $user_month = [
            'chart_title' => 'Usuarios por mes',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\User',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_type' => 'bar',
        ];
        $user_month_chart = new LaravelChart($user_month);

        $roles_chart = [
            'chart_title' => 'Usuarios por rol',
            'report_type' => 'group_by_string',
            'model' => 'App\Models\User',
            'group_by_field' => 'role_id',
            'chart_type' => 'pie',
            'filter_field' => 'created_at',
            'aggregate_function' => 'count',
            'data' => [
                'roles' => [
                    'admin' => $cantAdmin,
                    'cliente' => $cantClientes,
                ]
            ]
        ];
        $roles_chart_instance = new LaravelChart($roles_chart);

        
    // Fecha hace tres meses
    $threeMonthsAgo = Carbon::now()->subMonths(3);

    // Configuración del gráfico de pedidos por mes para los últimos tres meses
    $pedidos_month = [
        'chart_title' => 'Pedidos por mes',
        'report_type' => 'group_by_date',
        'model' => 'App\Models\Orden',
        'group_by_field' => 'fecha',
        'group_by_period' => 'month',
        'aggregate_function' => 'count',
        'chart_type' => 'bar',
        'filter_field' => 'fecha',
        'filter_from' => $threeMonthsAgo->toDateString(), // Filtrar desde hace tres meses
        'filter_to' => Carbon::now()->toDateString(), // Filtrar hasta la fecha actual
    ];

        $pedidos_month_chart = new LaravelChart($pedidos_month);

     // Obtener los productos más vendidos con sus cantidades
$productosMasVendidos = DetalleOrden::select('producto_id', DB::raw('SUM(cantidad) as total_vendido'))
->groupBy('producto_id')
->orderByDesc('total_vendido')
->take(3)
->get();

// Obtener los nombres de los productos y cantidades vendidas
$productosNombres = [];
$productosCantidades = [];
foreach ($productosMasVendidos as $detalle) {
$producto = Producto::find($detalle->producto_id); // Cambiar a findOrFail para manejar errores
if ($producto) {
    $productosNombres[] = $producto->nombre; // Aquí obtenemos el nombre del producto
    $productosCantidades[] = $detalle->total_vendido; // Utilizar el alias total_vendido
} else {
    // Manejo de productos no encontrados, si es necesario
    $productosNombres[] = 'Producto no encontrado'; 
    $productosCantidades[] = $detalle->total_vendido;
}
}
//dd($productosNombres, $productosCantidades);

// Crear el gráfico
$productos_chart = [
    'chart_title' => 'Top 3 Productos Más Vendidos',
    'report_type' => 'group_by_string',
    'model' => 'App\Models\DetalleOrden',
    'group_by_field' => 'producto_id', // Aunque agrupamos por producto_id, los nombres se utilizarán en labels
    'chart_type' => 'pie',
    'data' => [
        'labels' => $productosNombres, // Los nombres de los productos
        'datasets' => [
            [
                'label' => 'Cantidad Vendida',
                'data' => $productosCantidades, // Las cantidades vendidas
            ],
        ],
    ],
];




  // Obtener los productos con el stock actual y el stock mínimo
  $productos = Producto::all();

  // Preparar los datos para el gráfico
  $nombresProductos = $productos->pluck('nombre')->toArray();
  $stocksActuales = $productos->pluck('stock')->toArray();
  $stocksMinimos = $productos->pluck('stock_min')->toArray();


  $stock_chart = [
    'chart_title' => 'Stock Actual vs Stock Mínimo',
    'report_type' => 'group_by_string',
    'model' => 'App\Models\Producto',
    'group_by_field' => 'nombre',
    'chart_type' => 'line',
    'data' => [
        'labels' => $nombresProductos,
        'datasets' => [
            [
                'label' => 'Stock Actual',
                'data' => $stocksActuales,
                'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                'borderColor' => 'rgba(54, 162, 235, 1)',
                'borderWidth' => 1,
            ],
            [
                'label' => 'Stock Mínimo',
                'data' => $stocksMinimos,
                'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                'borderColor' => 'rgba(255, 99, 132, 1)',
                'borderWidth' => 1,
            ],
        ],
    ],
    'options' => [
        'scales' => [
            'x' => [
                'title' => [
                    'display' => true,
                    'text' => 'Productos',
                ],
            ],
            'y' => [
                'title' => [
                    'display' => true,
                    'text' => 'Cantidad',
                ],
                'ticks' => [
                    'beginAtZero' => false,
                    'stepSize' => 5,
                    'min' => 5,  // Configura el mínimo valor visible del eje Y
                    'max' => max($stocksActuales) + 5, // Configura el máximo valor visible del eje Y para incluir un poco de margen
                ],
            ],
        ],
    ],
];

$stock_minimo_chart_instance = new LaravelChart($stock_chart);

$productos_chart_instance = new LaravelChart($productos_chart);

$ventas_por_categoria = [
    'chart_title' => 'Ventas por Categoría de Producto',
    'report_type' => 'group_by_string',
    'model' => 'App\Models\Producto',
    'group_by_field' => 'categoria_id',
    'chart_type' => 'bar',
    'aggregate_function' => 'sum',
    'filter_field' => 'estado_id',
    'filter_value' => 8,
    'data' => [
        'labels' => Categoria::pluck('nombre')->toArray(), // Suponiendo que tienes un modelo Categoria
        'datasets' => [
            [
                'label' => 'Ventas',
                'data' => Producto::selectRaw('SUM(detalle_ordens.cantidad) as total_vendido')
                    ->join('detalle_ordens', 'productos.id', '=', 'detalle_ordens.producto_id')
                    ->groupBy('productos.categoria_id')
                    ->pluck('total_vendido')
                    ->toArray(),
            ],
        ],
    ],
];
$ventas_por_categoria_chart = new LaravelChart($ventas_por_categoria);


        return view('dashboard',[
            'cantUser' => $cantUser,
            'cantClientes' => $cantClientes,
            'cantProdVendidos' => $cantProdVendidos,
            'cantVentasObtenidas' => $cantVentasObtenidas,
            'cantidadTotalVentas'=> $cantidadTotalVentas,
            'cantAdmin' => $cantAdmin,
            'user_month_chart' => $user_month_chart,
            'pedidos_month_chart' => $pedidos_month_chart,
            'roles_chart_instance' => $roles_chart_instance,
            'productos_chart_instance' => $productos_chart_instance,
            'stock_minimo_chart_instance' => $stock_minimo_chart_instance,
            'ventas_por_categoria_chart'=> $ventas_por_categoria_chart,
            'visits' => $visits,
        ]);
    }
}
