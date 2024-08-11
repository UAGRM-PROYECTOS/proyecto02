<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre'
    ];
    public function getEssentialData(){
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,

        ];
    }

   /* public function cortarServicio()
    {
        $this->cortado = true;
        $this->save();
    }*/

}
