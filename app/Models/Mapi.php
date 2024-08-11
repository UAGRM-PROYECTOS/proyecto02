<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapi extends Model
{
    use HasFactory;
    protected $table = 'ordens';

    protected $fillable = [
        'fecha_hora', 'metodo_pago_id', 'estado_id','monto'
        // Otras columnas según sea necesario
    ];

    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'metodo_pago_id');
    }
    public function Estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
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
