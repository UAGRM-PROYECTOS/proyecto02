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
            ['usuario', 'listar', 'ninguno', 'usuario listar'],
            ['usuario', 'agregar', 'name,email,password,rol', 'usuario agregar [admtest;admtest@gmail.com;1234567890;admin]'],
            ['usuario', 'modificar', 'id,name,email,password,rol', 'usuario modificar [1;admtest1;admtest1@gmail.com;1234567890;admin]'],
            ['usuario', 'eliminar', 'id', 'usuario eliminar [1]'],

            ['cliente', 'listar', 'ninguno', 'cliente listar'],
            ['cliente', 'agregar', 'name,email,password,direccion,telefono,sexo,cedula_nit', 'cliente agregar [cliente1;cliente1@gmail.com;1234567890;Av Lujan #13 5to anillo;69490587;M;9814088'],
            ['cliente', 'modificar', 'id,name,email,password,direccion,telefono,sexo,cedula_nit', 'cliente agregar [1;cliente1;cliente1@gmail.com;1234567890;Av Lujan #13 5to anillo;69490587;M;9814088'],
            ['cliente', 'eliminar', 'id', 'cliente eliminar [1]'],
            
            ['producto', 'listar', 'ninguno', 'producto listar'],
            ['producto', 'agregar', 'cod,nombre,descripcion,unidad,precio_venta,categoria_id', 'producto agregar [PRO01;producto1;producto1 Describir;UNIDAD;0.4;FRUTAS/VERDURAS]'],
            ['producto', 'modificar', 'cod,nombre,descripcion,unidad,precio_venta,categoria_id', 'producto modificar [PRO01;producto1;producto1 Describir;KG;0.4;FRUTAS/VERDURAS]'],
            ['producto', 'eliminar', 'id', 'producto eliminar [1]'],

            ['categoria', 'listar', 'ninguno', 'categoria listar'],
            ['categoria', 'agregar', 'nombre', 'categoria agregar [categoria1]'],

            ['proveedor', 'listar', 'ninguno', 'proveedor listar'],
            ['proveedor', 'agregar', 'nombre,direccion,telefono,email', 'proveedor agregar [proveedor1;proveedor@gmail.com;Av Lujan #13 5to anillo;69490587]'],

            ['ingreso', 'listar', 'ninguno', 'ingreso listar'],
            ['ingreso', 'agregar', 'proveedor_id', 'ingreso agregar [1]'],
    
            ['detalleingreso', 'listar', 'ingreso_id', 'detalleingreso listar [1]'],
            ['detalleingreso', 'agregar', 'ingreso_id,producto,cantidad', 'detalleingreso agregar [1;MANZANA;1]'],
          
    
    
            ['orden', 'listar', 'ninguno', 'orden listar'],
            ['orden', 'agregar', 'cliente,estado_id', 'orden agregar [email;CREAR]'],
            ['orden', 'modificar', 'id,estado_id', 'orden modificar [1;PAGADO/ENVIADO]'],
            ['orden', 'eliminar', 'id', 'orden eliminar [1]'],
    /*
            ['detalle-orden', 'listar', 'orden_id', 'detalle-orden listar [1]'],
            ['detalle-orden', 'agregar', 'orden_id,producto,cantidad', 'detalle-orden agregar [1;MANZANA;1]'],
            ['detalle-orden', 'modificar', 'id,orden_id,producto,cantidad', 'detalle-orden modificar [1;MANZANA;2]'],
            ['detalle-orden', 'eliminar', 'orden_id,producto', 'detalle-orden eliminar [1;MANZANA]'],
            
            ['pago', 'listar', 'ninguno', 'pago listar'],
            ['pago', 'agregar', 'orden_id,nombre,monto', 'pago agregar [1;Clinete;0.4]'],
            ['pago', 'modificar', 'id,transaccion,estado_id', 'pago modificar [1;1877968;PAGADO]'],

            ['estado', 'listar', 'ninguno', 'estado listar'],
            ['valuacion', 'listar', 'ninguno', 'valuacion listar'],
            ['metodo', 'listar', 'ninguno', 'metodo listar'],

            ['salida', 'listar', 'ninguno', 'salida listar'],

*/

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
