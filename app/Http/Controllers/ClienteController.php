<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ClienteRequest;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Middleware;

date_default_timezone_set('America/La_Paz');
class ClienteController extends Controller
{   
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = User::query();

        // Filtro de usuarios basado en el rol usando Spatie
        if ($request->filled('user_role')) {
            $role = $request->input('user_role');
            if (in_array($role, ['cliente', 'admin'])) {
                // Filtrar por usuarios con el rol especificado usando Spatie
                $query->whereHas('roles', function ($q) use ($role) {
                    $q->where('name', $role);
                });
            }
        }

        $visits = Visit::where(['page_name' => 'clientes.index'])->first();

        $clientes = $query->paginate(10);

        return view('cliente.index', [
            'visits' => $visits,
            'clientes' => $clientes
        ]);
}

    public function indexApi()
    {
        $clientes =User::role('cliente')->get();
        return response()->json($clientes, 200);

      
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $cliente = new User();
        $visits = Visit::where(['page_name' => 'clientes.create'])->first();
        return view('cliente.create', compact('cliente','visits'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClienteRequest $request): RedirectResponse
    {

        User::create($request->validated())->assignRole('cliente');

        return Redirect::route('clientes.index')
            ->with('success', 'Cliente created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $cliente = User::find($id);
        $visits = Visit::where(['page_name' => 'clientes.show'])->first();
        return view('cliente.show', compact('cliente','visits'));
    }

    public function showApi(string $id)
    {
      /*  $coord = Coordenada::find($id);
        if ($coord) return response()->json($coord, 200);
        return response()->json(['message' => 'Coordenada no encontrada'], 404);
        */
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $cliente = User::find($id);
        $visits = Visit::where(['page_name' => 'clientes.edit'])->first();
        return view('cliente.edit', compact('cliente','visits'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClienteRequest $request, User $cliente): RedirectResponse
    {
        $cliente->update($request->validated());

        return Redirect::route('clientes.index')
            ->with('success', 'Cliente updated successfully');
    }

    public function updateApi(Request $request, string $id)
    {
        /*$validator = Validator::make($request->all(), [
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'nombre_beneficiario' => 'required|max:70',
            'codigo_unidad_vecinal' => 'required|numeric',
            'cantidad_facturas' => 'required|numeric',
            'UMZ' => 'required',
            // 'tipo_de_red' => 'required',
            'codigo_factura' => 'required',
            'importe_factura' => 'required|numeric',
        ],[
            'latitud.required' => 'La latitud es requerida',
            'latitud.numeric' => 'La latitud debe ser un número',
            'longitud.required' => 'La longitud es requerida',
            'longitud.numeric' => 'La longitud debe ser un número',
            'nombre_beneficiario.required' => 'El nombre del beneficiario es requerido',
            'nombre_beneficiario.max' => 'El nombre del beneficiario no debe exceder los 70 caracteres',
            'codigo_unidad_vecinal.required' => 'El código de la unidad vecinal es requerido',
            'codigo_unidad_vecinal.numeric' => 'El código de la unidad vecinal debe ser un número',
            'cantidad_facturas.required' => 'La cantidad de facturas es requerida',
            'cantidad_facturas.numeric' => 'La cantidad de facturas debe ser un número',
            'UMZ.required' => 'La UMZ es requerida',
            // 'tipo_de_red.required' => 'El tipo de red es requerido',
            'codigo_factura.required' => 'El código de la factura es requerido',
            'importe_factura.required' => 'El importe de la factura es requerido',
            'importe_factura.numeric' => 'El importe de la factura debe ser un número',
        ]);

        if ($validator->fails()) return response()->json($validator->errors(), 400);

        $coord = Coordenada::find($id);
        if ($coord) {
            $coord->update($request->all());
            return response()->json(['message' => 'Coordenada actualizada correctamente'], 200);
        }
        return response()->json(['message' => 'Coordenada no encontrada'], 404);
        */
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        User::find($id)->delete();

        return Redirect::route('clientes.index')
            ->with('success', 'Cliente deleted successfully');
    }

    public function destroyApi(string $id)
    {
      /*  $coord = Coordenada::find($id);
        if ($coord) {
            $coord->delete();
            return response()->json(['message' => 'Coordenada eliminada correctamente'], 200);
        }
        return response()->json(['message' => 'Coordenada no encontrada'], 404);*/
    }

}
