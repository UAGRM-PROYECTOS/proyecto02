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
use App\Models\User;
use App\Models\Visit;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
date_default_timezone_set('America/La_Paz');
class EntregaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $ordens = Orden::where('estado_id', 8)->paginate(10);
        $visits = Visit::where(['page_name' => 'entregas.index'])->first();
        return view('entrega.index', compact('ordens','visits'))
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
        $visits = Visit::where(['page_name' => 'entregas.create'])->first();
        return view('entrega.create', compact('orden','estados','clientes','visits'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrdenRequest $request): RedirectResponse
    {
        //Orden::create($request->validated());
        $id= Auth::id();
        Orden::create([
            'cliente_id' => $id,
            'estado_id' => 9, 
            'total' => 00.00, 
            'fecha' => Carbon::now(), // Current date and time
            
        ]);
        
        return Redirect::route('entregas.index')
            ->with('success', 'Orden created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $orden = Orden::find($id);
        $detalleOrdens  = DetalleOrden::where('orden_id', $id)->paginate(10);
        $visits = Visit::where(['page_name' => 'entregas.show'])->first();
        return view('entrega.show', compact('orden','detalleOrdens','visits'));
    }
    public function ordenPedido($id): View
    {
        try {
            // Buscar la orden por su ID
            $orden = Orden::findOrFail($id);
    
            // Cambiar el estado de la orden
            $orden->estado_id = 5; // Estado que indica que el pedido ha sido realizado
            $orden->save();
    
            // Obtener los detalles de la orden paginados (si es necesario)
            $detalleOrdens = DetalleOrden::where('orden_id', $orden->id)->paginate();

            $pedidoRealizado='Pedido Realizao con exito';
    
            // Devolver la vista de la orden con los detalles y un mensaje indicando que ha sido pedido
            return view('entreg.show', compact('orden', 'detalleOrdens', 'pedidoRealizado'));
    
        } catch (ModelNotFoundException $e) {
            // Manejar el caso donde no se encuentra la orden
            return Redirect::back()->with('error', 'No se pudo encontrar la orden.');
        }
    }

    public function addDetalleOrden(Request $request): RedirectResponse
{
        // Recibir los parámetros del formulario
        $cantidad = $request->input('cantidad');
        $precio = $request->input('precio');
        $idProducto = $request->input('idProducto');
        $ordenId = $request->input('orden');
    
        // Validar y obtener la orden actual
        $orden = Orden::findOrFail($ordenId);
    
        // Crear un nuevo detalle de orden
        $detalleOrden = new DetalleOrden();
        $detalleOrden->orden_id = $orden->id;
        $detalleOrden->producto_id = $idProducto;
        $detalleOrden->cantidad = $cantidad;
        $detalleOrden->precio_unitario = $precio;
        // Calcular el precio total, si es necesario
        $detalleOrden->precio_total = $cantidad * $precio; // Ejemplo básico, ajusta según tu lógica
    
        // Guardar el detalle de orden
        $detalleOrden->save();
    
        // Actualizar el total de la orden
        $orden->total += $detalleOrden->precio_total;
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
        $clientes = User::role('cliente')->get();
        $visits = Visit::where(['page_name' => 'entregas.edit'])->first();
        return view('entrega.edit', compact('orden','estados','clientes','visits'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrdenRequest $request, Orden $orden): RedirectResponse
    {
        $orden->update($request->validated());
        $salidaController = new SalidaController();
        $salidaController->store($orden->id);
        return Redirect::route('entregas.index')
            ->with('success', 'Orden updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Orden::find($id)->delete();

        return Redirect::route('entregas.index')
            ->with('success', 'Orden deleted successfully');
    }
}
