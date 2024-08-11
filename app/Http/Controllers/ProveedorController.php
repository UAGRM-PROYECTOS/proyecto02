<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ProveedorRequest;
use App\Models\Visit;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
date_default_timezone_set('America/La_Paz');
class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $proveedors = Proveedor::paginate();
        $visits = Visit::where(['page_name' => 'proveedors.index'])->first();
        return view('proveedor.index', compact('proveedors','visits'))
            ->with('i', ($request->input('page', 1) - 1) * $proveedors->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $proveedor = new Proveedor();

        return view('proveedor.create', compact('proveedor'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProveedorRequest $request): RedirectResponse
    {
        Proveedor::create($request->validated());

        return Redirect::route('proveedors.index')
            ->with('success', 'Proveedor created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $proveedor = Proveedor::find($id);

        return view('proveedor.show', compact('proveedor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $proveedor = Proveedor::find($id);

        return view('proveedor.edit', compact('proveedor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProveedorRequest $request, Proveedor $proveedor): RedirectResponse
    {
        $proveedor->update($request->validated());

        return Redirect::route('proveedors.index')
            ->with('success', 'Proveedor updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Proveedor::find($id)->delete();

        return Redirect::route('proveedors.index')
            ->with('success', 'Proveedor deleted successfully');
    }
}
