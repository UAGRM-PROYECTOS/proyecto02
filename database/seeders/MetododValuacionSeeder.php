<?php

namespace Database\Seeders;

use App\Models\MetodoValuacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MetododValuacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MetodoValuacion::create(['nombre' => 'PEPS', 'descripcion' => 'PRIMERO EN ENTRAR PRIMERO EN SALIR']);
        MetodoValuacion::create(['nombre' => 'UEPS' ,'descripcion' => 'ULTIMO EN ENTRAR PRIMERO EN SALIR']);
        MetodoValuacion::create(['nombre' => 'CP' , 'descripcion' => 'COSTO PROMEDIO']);
    }
}
