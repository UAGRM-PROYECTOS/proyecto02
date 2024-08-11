<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthApiController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:70',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ],[
            'name.required' => 'El nombre es requerido',
            'name.max' => 'El nombre no debe exceder los 70 caracteres',
            'email.required' => 'El email es requerido',
            'email.email' => 'El email no es válido',
            'email.unique' => 'El email ya está registrado',
            'password.required' => 'La contraseña es requerida',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres'
        ]);

        if ($validator->fails()) return response()->json($validator->errors(), 400);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'user' => $user->getEssentialData(),
            'message' => 'Usuario registrado con éxito'
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if(auth()->attempt($credentials)) {
            $user = auth()->user();
            $user = User::find($user->id); //el user del Auth:: o auth() no tiene los métodos de HasApiTokens

            $token = $request->user()->createToken('auth_token')->plainTextToken;
            return response()->json([
                'user' => $user->getEssentialData(),
                'token' => $token,
                'token_type' => 'Bearer'
            ], 200);
        }
        return response()->json([
            'message' => 'Credenciales incorrectas'
        ], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Sesión finalizada']);
    }
}
