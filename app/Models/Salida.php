<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Salida
 *
 * @property $id
 * @property $metodovaluacion_id
 * @property $orden_id
 * @property $estado_id
 * @property $fecha_salida
 * @property $created_at
 * @property $updated_at
 *
 * @property Estado $estado
 * @property MetodoValuacion $metodoValuacion
 * @property Orden $orden
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Salida extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['metodovaluacion_id', 'orden_id', 'estado_id', 'fecha_salida'];


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
    public function metodoValuacion()
    {
        return $this->belongsTo(\App\Models\MetodoValuacion::class, 'metodovaluacion_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orden()
    {
        return $this->belongsTo(\App\Models\Orden::class, 'orden_id', 'id');
    }
    
}
