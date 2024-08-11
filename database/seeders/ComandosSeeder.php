<?php

namespace Database\Seeders;

use App\Models\Comando;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComandosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comandos = [
            ['comandos', 'listar', 'ninguno', 'help listar'],
            ['producto', 'listar', 'ninguno', 'producto listar'],
            ['usuario', 'listar', 'ninguno', 'usuario listar'],
            ['venta', 'listar', 'ninguno', 'venta listar'],


        ];

        foreach ($comandos as $comando) {
            Comando::create([
                'caso_de_uso' => $comando[0],
                'accion' => $comando[1],
                'parametro' => $comando[2],
                'ejemplo' => $comando[3],
            ]);
        }
    }
}
