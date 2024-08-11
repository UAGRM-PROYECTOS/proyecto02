<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

    class Comando extends Model
    {
        protected $table = 'comando';
        protected $fillable = ['caso_de_uso', 'accion', 'parametro', 'ejemplo'];
    }
