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
class AdmController extends Controller
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
        return view('cliente.createAdm', compact('cliente','visits'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClienteRequest $request): RedirectResponse
    {

        User::create($request->validated())->assignRole('admin');

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

   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        User::find($id)->delete();

        return Redirect::route('clientes.index')
            ->with('success', 'Cliente deleted successfully');
    }

   
}
