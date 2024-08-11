<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Producto
 *
 * @property $id
 * @property $cod_barra
 * @property $nombre
 * @property $descripcion
 * @property $unidad
 * @property $imagen
 * @property $precio
 * @property $costo_promedio
 * @property $stock
 * @property $stock_min
 * @property $categoria_id
 * @property $created_at
 * @property $updated_at

 *
 * @property Categoria $categoria
 * @property DetalleIngreso[] $detalleIngresos
 * @property DetalleOrden[] $detalleOrdens
 * @property Inventario[] $inventarios
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Producto extends Model
{
    
    protected $perPage = 20;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['cod_barra', 'nombre', 'descripcion','unidad','imagen', 'precio', 'stock', 'stock_min', 'categoria_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoria()
    {
        return $this->belongsTo(\App\Models\Categoria::class, 'categoria_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detalleIngresos()
    {
        return $this->hasMany(\App\Models\DetalleIngreso::class, 'id', 'producto_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detalleOrdens()
    {
        return $this->hasMany(\App\Models\DetalleOrden::class, 'id', 'producto_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inventarios()
    {
        return $this->hasMany(\App\Models\Inventario::class, 'id', 'producto_id');
    }
    
}
