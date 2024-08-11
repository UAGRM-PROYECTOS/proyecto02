<?php

namespace App\Http\Controllers;

use App\Models\Ingreso;
use App\Models\Proveedor;
use App\Models\DetalleIngreso;
use App\Models\Producto;
use App\Models\MetodoValuacion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\IngresoRequest;
use App\Models\Visit;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
date_default_timezone_set('America/La_Paz');
class IngresoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $ingresos = Ingreso::paginate();
        $visits = Visit::where(['page_name' => 'ingresos.index'])->first();
        return view('ingreso.index', compact('ingresos','visits'))
            ->with('i', ($request->input('page', 1) - 1) * $ingresos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $ingreso = new Ingreso();
        $proveedores = Proveedor::all(); 
        return view('ingreso.create', compact('ingreso', 'proveedores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IngresoRequest $request): RedirectResponse
    {
        Ingreso::create($request->validated());
        return Redirect::route('ingresos.index')
            ->with('success', 'Ingreso created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $ingreso = Ingreso::find($id);
        $detalleIngresos = DetalleIngreso::where('ingreso_id', $id)->paginate(10);
        return view('ingreso.show', compact('ingreso','detalleIngresos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $ingreso = Ingreso::find($id);
        $proveedores = Proveedor::all(); 
        $metodovaluacions =MetodoValuacion::all();
        return view('ingreso.edit', compact('ingreso','proveedores','metodovaluacions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IngresoRequest $request, Ingreso $ingreso): RedirectResponse
    {
        $ingreso->update($request->validated());

        return Redirect::route('ingresos.index')
            ->with('success', 'Ingreso updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Ingreso::find($id)->delete();

        return Redirect::route('ingresos.index')
            ->with('success', 'Ingreso deleted successfully');
    }
}
