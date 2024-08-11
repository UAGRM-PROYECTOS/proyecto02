<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Pago
 *
 * @property $id
 * @property $orden_id
 * @property $metodopagos_id
 * @property $estado_id
 * @property $nombre
 * @property $monto_pago
 * @property $fecha_pago
 * @property $created_at
 * @property $updated_at
 *
 * @property Estado $estado
 * @property MetodoPago $metodoPago
 * @property Orden $orden
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Pago extends Model
{

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['orden_id', 'metodopagos_id', 'estado_id', 'nombre', 'monto_pago', 'fecha_pago','transaccion'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estado()
    {
        return $this->belongsTo(\App\Models\Estado::class, 'estado_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function metodoPago()
    {
        return $this->belongsTo(\App\Models\MetodoPago::class, 'metodopagos_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orden()
    {
        return $this->belongsTo(\App\Models\Orden::class, 'orden_id', 'id');
    }

}
