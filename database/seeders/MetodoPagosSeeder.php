<?php

namespace Database\Seeders;

use App\Models\MetodoPago;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MetodoPagosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MetodoPago::create(['nombre' => 'Efectivo']);
        MetodoPago::create(['nombre' => 'Tarjeta de débito/crédito']);
        MetodoPago::create(['nombre' => 'Tigo Money']);
        MetodoPago::create(['nombre' => 'Tranferencias Bancos QR']);
    }
}
