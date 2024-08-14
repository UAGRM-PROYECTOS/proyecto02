<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Orden;
use App\Models\DetalleOrden;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ProductoRequest;
use Carbon\Carbon;
use App\Models\Visit;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Auth;
date_default_timezone_set('America/La_Paz');
class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $productos = Producto::paginate();
        $visits = Visit::where(['page_name' => 'productos.index'])->first();
        return view('producto.index', compact('productos','visits'))
            ->with('i', ($request->input('page', 1) - 1) * $productos->perPage());
    }
    public function CatalogoView()
    {
        $productos = Producto::all();
        $categorias = Categoria::get();
        $detallesPedidos = DetalleOrden::get();
        $visits = Visit::where(['page_name' => 'producto.catalogo'])->first();
 
        if (auth()->user()) {
            $pedidos = Orden::where('cliente_id', auth()->user()->id);
            $pedidos = $pedidos->where('estado_id', 8)->first();
            

            $orden = Orden::where('cliente_id', Auth::user()->id)
            ->where('estado_id', 9) 
            ->latest('fecha') 
            ->first();

            return view('producto.catalogo', compact('productos', 'categorias', 'orden', 'detallesPedidos','visits'));
        }
        $orden =  Orden::create([
            'cliente_id' => Auth::user()->id,
            'estado_id' => 9, 
            'total' => 00.00, 
            'fecha' => Carbon::now(), // Current date and time
            
        ]);
        dd($orden);
        return view('producto.catalogo', compact('productos', 'categorias', 'orden', 'detallesPedidos','visits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $producto = new Producto();
        $imagen= Producto::get('imagen');
        $categorias = Categoria::all(); 
        $unidades =['KG','UNIDAD','LIB','LITRO'];
        $visits = Visit::where(['page_name' => 'productos.create'])->first();
        return view('producto.create', compact('producto', 'categorias','imagen','unidades','visits'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductoRequest $request): RedirectResponse
    {
       // Handle image upload
       if ($request->hasFile('imagen')) {
        $imagePath = $request->file('imagen')->getRealPath();
        $uploadedFileUrl = Cloudinary::upload($imagePath)->getSecurePath();
    }
    $data = $request->validated();
    $data = array_map('strtoupper', $data);

    // Create the product
    
    $producto = Producto::create($data);
    $producto->cod_barra= 'PRO0' . $producto->id;
    $producto->save();

    // Set the imagen field if uploaded
    if (isset($uploadedFileUrl)) {
        $producto->imagen = $uploadedFileUrl;
        $producto->save();
    }

        return Redirect::route('productos.index')
            ->with('success', 'Producto created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $producto = Producto::find($id);
        $visits = Visit::where(['page_name' => 'productos.show'])->first();
        return view('producto.show', compact('producto','visits'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $producto = Producto::find($id);
        $categorias = Categoria::all(); 
        $unidades =['KG','UNIDAD','LIB','LITRO'];
        $visits = Visit::where(['page_name' => 'productos.edit'])->first();
        return view('producto.edit', compact('producto', 'categorias','unidades','visits'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductoRequest $request, Producto $producto): RedirectResponse
    {
       
        // Handle image upload to Cloudinary
        if ($request->hasFile('imagen')) {
            $imagePath = $request->file('imagen')->getRealPath();
            $uploadedFile = Cloudinary::upload($imagePath);
            $uploadedFileUrl = $uploadedFile->getSecurePath();

            // Update the product's imagen field
            $producto->imagen = $uploadedFileUrl;
        }

        $producto->update($request->validated());

    
        return Redirect::route('productos.index')
            ->with('success', 'Producto updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Producto::find($id)->delete();

        return Redirect::route('productos.index')
            ->with('success', 'Producto deleted successfully');
    }

    public function search(Request $request)
    {
        $query = strtolower($request->input('query')); 
        $productos = Producto::whereRaw('LOWER(nombre) LIKE ?', ['%' . $query . '%'])
            ->get(['id', 'nombre']); 
        return response()->json($productos);
    }
    public function generarReporte()
    {
        $productos = Producto::all();
        $pdf = Pdf::loadView('producto.reporte', compact('productos'));
        return $pdf->download('reporte_producto.pdf');
    }
}
