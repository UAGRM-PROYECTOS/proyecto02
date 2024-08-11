<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CategoriaRequest;
use App\Models\Visit;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
date_default_timezone_set('America/La_Paz');
class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $categorias = Categoria::paginate();
        $visits = Visit::where(['page_name' => 'categorias.index'])->first();
        return view('categoria.index', compact('categorias','visits'))
            ->with('i', ($request->input('page', 1) - 1) * $categorias->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categoria = new Categoria();
        $visits = Visit::where(['page_name' => 'categorias.create'])->first();
        return view('categoria.create', compact('categoria','visits'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoriaRequest $request): RedirectResponse
    {
        Categoria::create($request->validated());

        return Redirect::route('categorias.index')
            ->with('success', 'Categoria created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $categoria = Categoria::find($id);
        $visits = Visit::where(['page_name' => 'categorias.show'])->first();
        return view('categoria.show', compact('categoria','visits'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $categoria = Categoria::find($id);
        $visits = Visit::where(['page_name' => 'categorias.edit'])->first();
        return view('categoria.edit', compact('categoria','visits'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoriaRequest $request, Categoria $categoria): RedirectResponse
    {
        $categoria->update($request->validated());

        return Redirect::route('categorias.index')
            ->with('success', 'Categoria updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Categoria::find($id)->delete();

        return Redirect::route('categorias.index')
            ->with('success', 'Categoria deleted successfully');
    }
}
