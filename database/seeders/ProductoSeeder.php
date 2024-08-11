<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $productos = [
            ['MANZANA', 'PRO001', 'MANZANA ROJA FRESCA', 'UNIDAD', 'https://res.cloudinary.com/drjvgyusx/image/upload/v1721250339/ssejcxxpcgxgtknccvl0.jpg', 0.30, 0, 5, 1],
            ['BANANA', 'PRO002', 'BANANAS ORGANICAS', 'KG', 'https://res.cloudinary.com/drjvgyusx/image/upload/v1721250471/tolmwumxypd7pjliemeq.jpg', 0.40, 0, 5, 1],
            ['ZANAHORIA', 'PRO003', 'ZANAHORIAS FRESCAS', 'KG', 'https://res.cloudinary.com/drjvgyusx/image/upload/v1721250499/hskzlp1xc2kxgxyrzsut.webp', 0.10, 0, 5, 2],
            ['LECHUGA', 'PRO004', 'LECHUGA ROMANA', 'UNIDAD', 'https://res.cloudinary.com/drjvgyusx/image/upload/v1721250521/edjam23io0hkbxqhbtvs.webp', 0.50, 0, 5, 2],
            ['NARANJA', 'PRO005', 'NARANJAS ORGANICAS', 'UNIDAD', 'https://res.cloudinary.com/drjvgyusx/image/upload/v1721250546/bi850vc5h7ehbdjlecum.jpg', 0.35, 0, 5, 1],
            ['KIWI', 'PRO006', 'KIWI VERDE', 'KG', 'https://res.cloudinary.com/drjvgyusx/image/upload/v1721250574/cxsjzthx1vlfji5nxg2x.jpg', 1.00, 0, 5, 1],
            ['ESPINACA', 'PRO007', 'ESPINACAS FRESCAS', 'UNIDAD', 'https://res.cloudinary.com/drjvgyusx/image/upload/v1721250592/s5ubdexkw4jv7c5k2ncu.webp', 0.60, 0, 5, 2],
            ['PEPINO', 'PRO008', 'PEPINOS HIDROPONICOS', 'UNIDAD', 'https://res.cloudinary.com/drjvgyusx/image/upload/v1721250618/tcnnqsmvtlrlopsszuvf.webp', 0.25, 0, 5, 2],
            ['PERA', 'PRO009', 'PERAS BARLETT', 'UNIDAD', 'https://res.cloudinary.com/drjvgyusx/image/upload/v1721250639/p6o7zfdebcy1ylaoa6yg.jpg', 0.50, 0, 5, 1],
            ['TOMATE', 'PRO010', 'TOMATES ORGNICOS', 'KG', 'https://res.cloudinary.com/drjvgyusx/image/upload/v1721250922/dd5tqeqlhw2ykweazpgt.webp', 0.20, 0, 5, 2]
        ];

        foreach ($productos as $producto) {
            Producto::create([
                'nombre' => $producto[0],
                'cod_barra' => $producto[1],
                'descripcion' => $producto[2],
                'unidad' => $producto[3],
                'imagen' => $producto[4],
                'precio' => $producto[5],
                'stock' => $producto[6],
                'stock_min' => $producto[7],
                'categoria_id' => $producto[8],
            ]);
        }

    }
}
