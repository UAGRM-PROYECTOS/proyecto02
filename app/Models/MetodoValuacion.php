<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MetodoValuacion
 *
 * @property $id
 * @property $nombre
 * @property $descripcion
 * @property $created_at
 * @property $updated_at
 *
 * @property Ingreso[] $ingresos
 * @property Salida[] $salidas
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class MetodoValuacion extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'descripcion'];

    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function salidas()
    {
        return $this->hasMany(\App\Models\Salida::class, 'id', 'metodovaluacion_id');
    }
    
}
