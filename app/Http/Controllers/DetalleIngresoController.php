<?php

namespace App\Http\Controllers;

use App\Models\DetalleIngreso;
use App\Models\Ingreso;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\DetalleIngresoRequest;
use App\Models\Inventario;
use App\Models\Producto;
use App\Models\Visit;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
date_default_timezone_set('America/La_Paz');
class DetalleIngresoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $detalleIngresos = DetalleIngreso::paginate();
        $visits = Visit::where(['page_name' => 'detalle-ingresos.index'])->first();
        return view('detalle-ingreso.index', compact('detalleIngresos','visits'))
            ->with('i', ($request->input('page', 1) - 1) * $detalleIngresos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {

    
        $detalleIngreso = new DetalleIngreso();
        $productos = Producto::all(); 
        $visits = Visit::where(['page_name' => 'detalle-ingresos.create'])->first();
        return view('detalle-ingreso.create', compact('detalleIngreso', 'productos','visits' ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DetalleIngresoRequest $request): RedirectResponse
{
    try {
        $ingreso = null; // Inicializar la variable $ingreso

        DB::transaction(function () use ($request, &$ingreso) {
            $validated = $request->validated();

            // Buscar si ya existe un detalle de ingreso con el mismo producto y mismo ingreso
            $detalleIngreso = DetalleIngreso::where('producto_id', $validated['producto_id'])
                ->where('ingreso_id', $validated['ingreso_id'])
                ->first();

            if ($detalleIngreso) {
                // Si existe, lanzar un error y cancelar la transacción
                throw new \Exception('El producto ya ha sido ingresado en este ingreso.');
            }

            // Si no existe, crear un nuevo registro
            $detalleIngreso = DetalleIngreso::create($validated);

            // Encontrar el ingreso asociado
            $ingreso = Ingreso::findOrFail($detalleIngreso->ingreso_id);

            // Sumar todos los detalles de ingresos asociados a este ingreso
            $totalIngreso = DetalleIngreso::where('ingreso_id', $ingreso->id)
                ->sum('costo_total');

            // Actualizar el total del ingreso con la suma
            $ingreso->total = $totalIngreso;
            $ingreso->save();

            // Manejar el inventario
            $producto = Producto::findOrFail($detalleIngreso->producto_id);
            $producto->stock += $detalleIngreso->cantidad; // Sumar la nueva cantidad
            $producto->save();

            // Buscar y actualizar el inventario existente
            $inventario = Inventario::where('producto_id', $detalleIngreso->producto_id)
                                    ->whereDate('fecha_ingreso', $detalleIngreso->ingreso->fecha_ingreso)
                                    ->first();

            if ($inventario) {
                // Si existe, actualizar la cantidad
                $inventario->cantidad_ingresada += $detalleIngreso->cantidad;
                $inventario->cantidad_actual += $detalleIngreso->cantidad;
                $inventario->costo_unitario = $validated['costo_unitario']; // Opcional: Actualizar costo unitario
                $inventario->save();
            } else {
                // Si no existe, crear un nuevo registro
                Inventario::create([
                    'producto_id' => $detalleIngreso->producto_id,
                    'cantidad_ingresada' => $detalleIngreso->cantidad,
                    'cantidad_actual' => $detalleIngreso->cantidad,
                    'costo_unitario' => $detalleIngreso->costo_unitario,
                    'fecha_ingreso' => $detalleIngreso->ingreso->fecha_ingreso,
                ]);
            }
        });

        return Redirect::route('ingresos.show', $ingreso->id)
            ->with('success', 'Detalle de ingreso creado con éxito.');
    } catch (\Exception $e) {
        // Redirigir con un mensaje de error
        return Redirect::back()->with('error', $e->getMessage());
    }
}

    
    

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        
        // Encuentra el ingreso asociado
        $ingreso = Ingreso::find($id);
        $productos = Producto::all(); 
        // Crea un nuevo detalle de ingreso asociado a este ingreso
        $detalleIngreso = new DetalleIngreso();
        $detalleIngreso->ingreso_id = $id; // Asigna el ID del ingreso al detalle de ingreso
        $visits = Visit::where(['page_name' => 'detalle-ingresos.show'])->first();
        return view('detalle-ingreso.create', compact('detalleIngreso', 'ingreso','productos','visits'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $detalleIngreso = DetalleIngreso::find($id);
        $productos = Producto::all(); 
        $visits = Visit::where(['page_name' => 'detalle-ingresos.edit'])->first();
        return view('detalle-ingreso.edit', compact('detalleIngreso', 'productos','visits'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DetalleIngresoRequest $request, DetalleIngreso $detalleIngreso): RedirectResponse
    {
        $ingreso = null;
    
        DB::transaction(function () use ($request, $detalleIngreso, &$ingreso) {
            try {
                // Obtener datos actuales del detalle de ingreso
                $cantidadAnterior = $detalleIngreso->cantidad;
                $costoUnitarioAnterior = $detalleIngreso->costo_unitario;
                $costoTotalAnterior = $detalleIngreso->costo_total;
    
                // Actualizar el detalle de ingreso con los nuevos datos
                $detalleIngreso->update($request->validated());
    
                // Recalcular el costo total con el nuevo costo unitario
                $nuevoCostoTotal = $detalleIngreso->cantidad * $detalleIngreso->costo_unitario;
    
                // Encontrar el ingreso asociado antes de la actualización
                $ingreso = Ingreso::findOrFail($detalleIngreso->ingreso_id);
    
                // Ajustar el total del ingreso
                $ingreso->total -= $costoTotalAnterior;
                $ingreso->total += $nuevoCostoTotal;
                $ingreso->save();
    
                // Actualizar el inventario
                $producto = Producto::findOrFail($detalleIngreso->producto_id);
    
                // Ajustar el stock del producto
                $producto->stock -= $cantidadAnterior; // Restar la cantidad anterior
                $producto->stock += $detalleIngreso->cantidad; // Sumar la nueva cantidad
                $producto->save();
    
                // Registrar o actualizar en inventario (opcional según el flujo)
                Inventario::updateOrCreate(
                    [
                        'producto_id' => $detalleIngreso->producto_id,
                        'fecha_ingreso' => $detalleIngreso->ingreso->fecha_ingreso,
                    ],
                    [
                        'cantidad' => $detalleIngreso->cantidad,
                        'costo_unitario' => $detalleIngreso->costo_unitario,
                    ]
                );
                
            } catch (ModelNotFoundException $e) {
                // Manejar excepción si no se encuentra el detalle de ingreso o ingreso
                return Redirect::back()->with('error', 'No se pudo encontrar el detalle de ingreso o el ingreso.');
            } catch (\Exception $e) {
                // Manejar otras excepciones
                return Redirect::back()->with('error', $e->getMessage());
            }
        });
    
        return Redirect::route('ingresos.show', $ingreso->id)
            ->with('success', 'Detalle de ingreso actualizado con éxito.');
    }
    

    public function destroy($id): RedirectResponse
    {
        $ingreso = null; 
        DB::transaction(function () use ($id, &$ingreso) {
            try {
            // Encontrar el detalle de ingreso que se va a eliminar
            $detalleIngreso = DetalleIngreso::findOrFail($id);
    
            // Encontrar el ingreso asociado
            $ingreso = Ingreso::findOrFail($detalleIngreso->ingreso_id);
    // Verificar si el total de la orden es menor que el precio total del detalle
         if ($ingreso->total < $detalleIngreso->costo_total) {
        throw new \Exception('El total no puede ser menor que cero.');
        }
            // Actualizar el total del ingreso restando el costo total del detalle de ingreso
            $ingreso->total -= $detalleIngreso->costo_total;
            $ingreso->save();
    
            // Eliminar el detalle de ingreso
            $detalleIngreso->delete();
        } catch (ModelNotFoundException $e) {
            // Manejar excepción si no se encuentra el detalle de orden o la orden
            return Redirect::back()->with('error', 'No se pudo encontrar el detalle de orden.');
        } catch (\Exception $e) {
            // Manejar otras excepciones
            return Redirect::back()->with('error', $e->getMessage());
        }
        });

        return Redirect::route('ingresos.show', $ingreso->id)
        ->with('success', 'DetalleIngreso deleted successfully.');
    }
}
