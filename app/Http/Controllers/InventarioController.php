<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\InventarioRequest;
use App\Models\Visit;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
date_default_timezone_set('America/La_Paz');
class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {

            $query = Inventario::query();
            $visits = Visit::where(['page_name' => 'inventarios.index'])->first();
            // Filtros
            if ($request->filled('order_by')) {
                $order = $request->input('order_by');
                $query->orderBy('fecha_ingreso', $order);
            }
        
            if ($request->filled('quantity_filter')) {
                $filter = $request->input('quantity_filter');
                switch ($filter) {
                    case 'zero':
                        $query->where('cantidad_actual', 0);
                        break;
                    case 'low':
                        $query->where('cantidad_actual', '<=', 5);
                        break;
                }
            }
        
            $inventarios = $query->paginate(10);
        
            return view('inventario.index', compact('inventarios','visits'))
            ->with('i', ($request->input('page', 1) - 1) * $inventarios->perPage());
        }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $inventario = new Inventario();

        return view('inventario.create', compact('inventario'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InventarioRequest $request): RedirectResponse
    {
        Inventario::create($request->validated());

        return Redirect::route('inventarios.index')
            ->with('success', 'Inventario created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $inventario = Inventario::find($id);

        return view('inventario.show', compact('inventario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $inventario = Inventario::find($id);

        return view('inventario.edit', compact('inventario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InventarioRequest $request, Inventario $inventario): RedirectResponse
    {
        $inventario->update($request->validated());

        return Redirect::route('inventarios.index')
            ->with('success', 'Inventario updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Inventario::find($id)->delete();

        return Redirect::route('inventarios.index')
            ->with('success', 'Inventario deleted successfully');
    }

    public function generarReporte()
    {
        $inventarios = Inventario::with('producto')->get();
        $pdf = Pdf::loadView('inventario.reporte', compact('inventarios'));
        return $pdf->download('reporte_inventario.pdf');
    }

}
