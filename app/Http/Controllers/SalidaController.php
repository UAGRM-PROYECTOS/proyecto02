<?php

namespace App\Http\Controllers;

use App\Models\Salida;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\SalidaRequest;
use App\Models\DetalleOrden;
use App\Models\Estado;
use App\Models\Inventario;
use App\Models\Orden;
use App\Models\Producto;
use App\Models\Visit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
date_default_timezone_set('America/La_Paz');
class SalidaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $salidas = Salida::paginate();
        $visits = Visit::where(['page_name' => 'salidas.index'])->first();
        return view('salida.index', compact('salidas','visits'))
            ->with('i', ($request->input('page', 1) - 1) * $salidas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $salida = new Salida();
        $estados = Estado::all();
        return view('salida.create', compact('salida','estados'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($ordenId)
    {
        // Obtiene la orden por su ID
        $orden = Orden::findOrFail($ordenId);
    
        // Obtiene los detalles de la orden relacionados con esta orden
        $detalleOrdenes = DetalleOrden::where('orden_id', $ordenId)->get();
        
        DB::beginTransaction();
        try {
            // Crear la nueva salida
            $salida = Salida::create([
                'metodovaluacion_id' => 1, // 1 -> PEPS por defecto
                'orden_id' => $orden->id,
                'estado_id' => 8, // Estado "ENVIADO"
                'fecha_salida' => now(),
            ]);
    
            // Iterar sobre cada detalle de la orden para ajustar el inventario
            foreach ($detalleOrdenes as $detalleOrden) {
                $producto = Producto::findOrFail($detalleOrden->producto_id);
    
                $inventario = Inventario::where('producto_id', $producto->id)
                                        ->orderBy('fecha_ingreso', 'asc')
                                        ->first();
    
                if ($inventario) {
                    $cantidadRestante = $inventario->cantidad_actual - $detalleOrden->cantidad;
    
                    if ($cantidadRestante >= 0) {
                        $inventario->update(['cantidad_actual' => $cantidadRestante]);
                    } else {
                        // Manejo de cantidades parciales
                        $inventario->update(['cantidad_actual' => 0]);
                        $producto->stock -= $detalleOrden->cantidad;
                        $producto->save();
                    }
                } else {
                    // Si no hay inventario suficiente, manejar el caso
                    throw new \Exception('No hay suficiente inventario para el producto: ' . $producto->nombre);
                }
            }
    
        
    
            DB::commit();
    
            return response()->json(['message' => 'Salidas registradas correctamente.']);
    
        } catch (\Exception $e) {
            DB::rollBack();
    
            // Maneja el error de manera adecuada, por ejemplo, devolviendo una respuesta de error o lanzando la excepción
            return response()->json(['error' => 'Error al registrar las salidas: ' . $e->getMessage()], 500);
        }
    }
    
        
    


    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
  
        $orden = Orden::find($id);
        $detalleOrdens  = DetalleOrden::where('orden_id', $id)->paginate(10);
        return view('salida.show', compact('detalleOrdens','orden'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $salida = Orden::find($id);
        $estados = Estado::all();
        return view('salida.edit', compact('salida','estados'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($request, $salida): RedirectResponse
    {
        $salida->update($request->validated());
        $salidaController = new SalidaController();
        $salidaController->store($salida->id);
        return Redirect::route('salidas.index')
            ->with('success', 'Salida updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Salida::find($id)->delete();

        return Redirect::route('salidas.index')
            ->with('success', 'Salida deleted successfully');
    }
}
