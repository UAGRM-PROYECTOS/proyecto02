<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\OrdenRequest;
use App\Models\DetalleOrden;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\DetalleOrdenRequest;
use App\Models\Estado;
use App\Models\Producto;
use App\Models\Salida;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
date_default_timezone_set('America/La_Paz');
class OrdenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
{
    $query = Orden::query();
    $visits = Visit::where(['page_name' => 'ordens.index'])->first();
    if ($request->filled('estado')) {
        $estado = $request->input('estado');
        
        // Buscamos el estado por su nombre
        $estadoId = Estado::where('nombre', $estado)->first()->id;

        // Filtramos las órdenes por estado_id
        $query->where('estado_id', $estadoId);
    }

    $ordens = $query->paginate(10);

    return view('orden.index', compact('ordens', 'visits'))
        ->with('i', ($request->input('page', 1) - 1) * $ordens->perPage());
}
public function pedidos(Request $request): View
{
    $visits = Visit::where(['page_name' => 'pedidos.pedidos'])->first();
    // Obtén el ID del usuario autenticado
    $userId = auth()->id();

    $query = Orden::query();

    // Filtra las órdenes por el ID del usuario autenticado
    $query->where('cliente_id', $userId);

    if ($request->filled('estado')) {
        $estado = $request->input('estado');
        
        // Buscamos el estado por su nombre
        $estadoId = Estado::where('nombre', $estado)->first()->id;

        // Filtramos las órdenes por estado_id
        $query->where('estado_id', $estadoId);
    }

    $ordens = $query->paginate(10);

    return view('orden.cliente', compact('ordens','visits'))
        ->with('i', ($request->input('page', 1) - 1) * $ordens->perPage());
}


    
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $orden = new Orden();
        $estados = Estado::all();
        $clientes = User::role('cliente')->get();
        return view('orden.create', compact('orden','estados','clientes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrdenRequest $request): RedirectResponse
    {
        Orden::create($request->validated());
       
        return Redirect::route('ordens.index')
            ->with('success', 'Orden created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {

        $visits = Visit::where(['page_name' => 'ordens.show'])->first();
        $orden = Orden::find($id);
        $detalleOrdens  = DetalleOrden::where('orden_id', $id)->paginate(10);
        return view('orden.show', compact('orden','detalleOrdens','visits'));
    }
    public function ordenVer($id): View
    {

        $visits = Visit::where(['page_name' => 'orden.ver'])->first();
        $orden = Orden::find($id);
        $detalleOrdens  = DetalleOrden::where('orden_id', $id)->paginate(10);
        return view('orden.ver', compact('orden','detalleOrdens','visits'));
    }
    public function ordenPedido($id): View
    {
      
        try {

            $orden = Orden::findOrFail($id);

            // Cambiar el estado de la orden
            $orden->estado_id = 5; // Estado que indica que el pedido ha sido realizado
            $orden->save();


            $detalleOrdens = DetalleOrden::where('orden_id', $orden->id)->paginate();

            $pedidoRealizado='Pedido Realizao con exito';
            $iduser= Auth::id();
            $cliente = User::findOrFail($iduser);

            return view('pago.create', compact('orden', 'detalleOrdens','cliente', 'pedidoRealizado'));

        } catch (ModelNotFoundException $e) {

            return Redirect::back()->with('error', 'No se pudo encontrar la orden.');
        }
    }

    public function addDetalleOrden(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $producto_id = $request->input('idProducto'); 
        $cantidad = $request->input('cantidad'); 
        $precio_unitario = $request->input('precio');
    
        // Verificar si ya existe una orden "creado" para el usuario
        $orden = Orden::where('cliente_id', $user->id)
                      ->where('estado_id', 9) 
                      ->first();
    
        if (!$orden) {
            // Si no existe una orden activa, crear una nueva
            $orden = Orden::create([
                'cliente_id' => $user->id,
                'estado_id' => 9,
                'total' => 0.00, 
                'fecha' => Carbon::now(), 
            ]);
        }
    
        // Verificar si el producto existe y tiene suficiente stock
        $producto = Producto::findOrFail($producto_id);
    
        if ($producto->stock < $cantidad) {
            // Si el stock es insuficiente, lanzar una excepción o manejar el error
            return Redirect::route('producto.catalogo', $orden->id)->withErrors(['error' => 'El producto no tiene suficiente stock disponible.']);
        }
    
        // Buscar si ya existe un detalle de orden con el mismo producto en la orden actual
        $detalleOrden = DetalleOrden::where('producto_id', $producto_id)
            ->where('orden_id', $orden->id)
            ->first();
    
        if ($detalleOrden) {
            // Si el producto ya existe, actualizar la cantidad y el precio total
            $detalleOrden->cantidad += $cantidad;
            $detalleOrden->precio_total = $detalleOrden->cantidad * $detalleOrden->precio_unitario;
            $detalleOrden->save();
        } else {
            // Si el producto no existe, crear un nuevo detalle
            $detalleOrden = $orden->detalleOrdens()->create([
                'producto_id' => $producto_id,
                'cantidad' => $cantidad,
                'precio_unitario' => $precio_unitario,
                'precio_total' => $cantidad * $precio_unitario,
                'orden_id' => $orden->id,
            ]);
        }
    
        // Descontar la cantidad del stock del producto
        $producto->stock -= $cantidad;
        $producto->save();
    
        // Sumar todos los detalles de ingresos asociados a este ingreso
        $totalOrden = DetalleOrden::where('orden_id', $orden->id)
            ->sum('precio_total');
    
        // Actualizar el total del ingreso con la suma
        $orden->total = $totalOrden;
        $orden->save();
    
        return Redirect::route('producto.catalogo', $orden->id)->with('success', 'Producto agregado correctamente a la orden.');
    }
    
    
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $orden = Orden::find($id);
        $estados = Estado::all();
        $clientes = User::all();
        return view('orden.edit', compact('orden','estados','clientes'));
    }

    /**
     * Update the specified resource in storage.
     */
    
     public function update(OrdenRequest $request, Orden $orden): RedirectResponse
{
    // Obtén el estado actual de la orden
    $estadoActual = $orden->estado_id;
    // Obtén el estado seleccionado del formulario
    $estadoSeleccionado = $request->input('estado_id');
    // Verifica si la orden ya ha sido enviada
    if ($estadoActual == '8' && $estadoSeleccionado == '8') {
        return Redirect::back()->with('error', 'La orden ya ha sido preparada y enviada. No se puede modificar.');
    }

    // Actualiza la orden con los datos validados
    $orden->update($request->validated());

    // Si el estado seleccionado es 8 (que corresponde a 'ENVIADO')
    if ($estadoSeleccionado == '8') {
        // Crea una instancia del controlador de salida y llama al método store
        $salidaController = new SalidaController();
        $salidaController->store($orden->id);
    }

    // Redirige con un mensaje de éxito
    return Redirect::route('ordens.index')
        ->with('success', 'Orden actualizada con éxito');
}


     
    public function destroy($id): RedirectResponse
    {
        Orden::find($id)->delete();

        return Redirect::route('ordens.index')
            ->with('success', 'Orden deleted successfully');
    }
}
