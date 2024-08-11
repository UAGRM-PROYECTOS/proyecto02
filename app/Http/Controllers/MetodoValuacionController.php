<?php

namespace App\Http\Controllers;

use App\Models\MetodoValuacion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\MetodoValuacionRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
date_default_timezone_set('America/La_Paz');
class MetodoValuacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $metodoValuacions = MetodoValuacion::paginate();

        return view('metodo-valuacion.index', compact('metodoValuacions'))
            ->with('i', ($request->input('page', 1) - 1) * $metodoValuacions->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $metodoValuacion = new MetodoValuacion();

        return view('metodo-valuacion.create', compact('metodoValuacion'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MetodoValuacionRequest $request): RedirectResponse
    {
        MetodoValuacion::create($request->validated());

        return Redirect::route('metodo-valuacions.index')
            ->with('success', 'MetodoValuacion created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $metodoValuacion = MetodoValuacion::find($id);

        return view('metodo-valuacion.show', compact('metodoValuacion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $metodoValuacion = MetodoValuacion::find($id);

        return view('metodo-valuacion.edit', compact('metodoValuacion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MetodoValuacionRequest $request, MetodoValuacion $metodoValuacion): RedirectResponse
    {
        $metodoValuacion->update($request->validated());

        return Redirect::route('metodo-valuacions.index')
            ->with('success', 'MetodoValuacion updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        MetodoValuacion::find($id)->delete();

        return Redirect::route('metodo-valuacions.index')
            ->with('success', 'MetodoValuacion deleted successfully');
    }
}
