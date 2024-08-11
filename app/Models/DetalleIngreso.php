<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DetalleIngreso
 *
 * @property $id
 * @property $producto_id
 * @property $ingreso_id
 * @property $cantidad
 * @property $costo_unitario
 * @property $costo_total
 * @property $created_at
 * @property $updated_at
 *
 * @property Ingreso $ingreso
 * @property Producto $producto
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class DetalleIngreso extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['producto_id', 'ingreso_id', 'cantidad', 'costo_unitario', 'costo_total'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ingreso()
    {
        return $this->belongsTo(\App\Models\Ingreso::class, 'ingreso_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function producto()
    {
        return $this->belongsTo(\App\Models\Producto::class, 'producto_id', 'id');
    }
    
}
