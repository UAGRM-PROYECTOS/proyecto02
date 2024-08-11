<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Orden;
use Carbon\Carbon;
date_default_timezone_set('America/La_Paz');
class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

    $request->session()->regenerate();


        /*Orden::create([
            'cliente_id' => $request->user()->id,
            'estado_id' => 9, 
            'total' => 00.00, 
            'fecha' => Carbon::now(), // Current date and time
            
        ]);*/
        
        // Attach the new order to the authenticated user
       //$request->user()->currentOrder()->associate($order);
        $request->user()->save();

        return redirect()->intended(route('producto.catalogo', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {

        $userId = Auth::id();

        // Retrieve the last order of the authenticated user
       /* $lastOrder = Orden::where('cliente_id', $userId)->orderBy('fecha', 'desc')->first();
    
        // Check if the last order exists and the total is 0
        if ($lastOrder && $lastOrder->total == 0.00) {
            // Delete the order
            $lastOrder->delete();
        }
*/
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
