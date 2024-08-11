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
            ['HELP', 'Lista de Comandos', 'NINGUNO', 'HELP', 'https://res.cloudinary.com/drjvgyusx/image/upload/v1721250339/ssejcxxpcgxgtknccvl0.jpg', 0.30, 0, 5, 1],

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
