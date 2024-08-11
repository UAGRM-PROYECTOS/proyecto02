<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Ingreso
 *
 * @property $id
 * @property $proveedor_id

 * @property $total
 * @property $fecha_ingreso
 * @property $created_at
 * @property $updated_at
 *

 * @property Proveedor $proveedor
 * @property DetalleIngreso[] $detalleIngresos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Ingreso extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['proveedor_id', 'total', 'fecha_ingreso'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proveedor()
    {
        return $this->belongsTo(\App\Models\Proveedor::class, 'proveedor_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detalleIngresos()
    {
        return $this->hasMany(\App\Models\DetalleIngreso::class, 'id', 'ingreso_id');
    }
    
}
