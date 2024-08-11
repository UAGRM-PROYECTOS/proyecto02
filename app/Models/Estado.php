<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Estado
 *
 * @property $id
 * @property $nombre
 * @property $created_at
 * @property $updated_at
 *
 * @property Orden[] $ordens
 * @property Pago[] $pagos
 * @property Salida[] $salidas
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Estado extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
   /* public function ordens()
    {
        return $this->hasMany(\App\Models\Orden::class, 'id', 'estado_id');
    }*/
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
   /* public function pagos()
    {
        return $this->hasMany(\App\Models\Pago::class, 'id', 'estado_id');
    }*/
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
   /* public function salidas()
    {
        return $this->hasMany(\App\Models\Salida::class, 'id', 'estado_id');
    }*/
    
}
