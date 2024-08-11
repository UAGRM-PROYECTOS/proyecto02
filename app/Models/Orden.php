<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Orden
 *
 * @property $id
 * @property $cliente_id
 * @property $estado_id
 * @property $total
 * @property $fecha
 * @property $created_at
 * @property $updated_at
 *
 * @property User $user
 * @property Estado $estado
 * @property DetalleOrden[] $detalleOrdens
 * @property Pago[] $pagos
 * @property Salida[] $salidas
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Orden extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['cliente_id', 'estado_id', 'total', 'fecha'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'cliente_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estado()
    {
        return $this->belongsTo(\App\Models\Estado::class, 'estado_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detalleOrdens()
    {
        return $this->hasMany(\App\Models\DetalleOrden::class, 'id', 'orden_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pagos()
    {
        return $this->hasMany(\App\Models\Pago::class, 'id', 'orden_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function salidas()
    {
        return $this->hasMany(\App\Models\Salida::class, 'id', 'orden_id');
    }

    public function orders()
    {
        return $this->hasMany(Orden::class, 'cliente_id', 'id');
    }

    /**
     * Get the current active order for the user.
     */
    public function currentOrder()
    {
        return $this->orders()->where('estado_id', 8)->latest()->first();
    }


    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'metodo_pago_id');
    }
   

    public function obtenerventa($ventaID)
{
    return Mapi::find($ventaID);
}

    public function verificarmetodopago($metodoPago)
    {
        return MetodoPago::find($metodoPago);
    }

    public function pagarventa($ventaID, $nuevaFecha, $nuevoMetodoPago, $nuevoEstado)
    {
        $venta = Mapi::findOrFail($ventaID);
        $venta->fecha_hora = $nuevaFecha;
        $venta->metodo_pago_id = $nuevoMetodoPago->id;
        $venta->estado_id = $nuevoEstado;
        $venta->save();

        return $venta;
    }
    
}
