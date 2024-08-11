<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pizza;
use App\Models\Tamano;
use App\Models\Categoria;
use App\Models\Estado;
use App\Models\MetodoPago;
use Illuminate\Http\Request;
date_default_timezone_set('America/La_Paz');
class SearchController extends Controller
{
    public function index($query){
        $users = User::where('name', 'like', '%'.$query.'%')->paginate(4);
        $categorias = Categoria::where('nombre', 'like', '%'.$query.'%')->paginate(4);
        $metodopagos = MetodoPago::where('nombre', 'like', '%'.$query.'%')->paginate(4);
        $estados = Estado::where('nombre', 'like', '%'.$query.'%')->paginate(4);

        return view('search.index', compact('users', 'categorias','metodopagos', 'estados'));
    }
}
