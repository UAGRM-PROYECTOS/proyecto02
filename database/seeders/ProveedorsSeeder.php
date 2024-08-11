<?php

namespace Database\Seeders;

use App\Models\Proveedor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProveedorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Proveedor::create([
            "name" => "Gretel Aguilera Pfizer",
            "email" => "ProveedorTuna@gmail.com",
            "telefono" => "78050589",
            "direccion" => "Av Melchor , Calle Flores #18",
        ]);

        Proveedor::create([
            "name" => "Luis Carlos Valdivia",
            "email" => "carlosExportGreen@gmail.com",
            "telefono" => "78050599",
            "direccion" => "Av Brasil , Calle Rivero #05",
        ]);
    }
}
