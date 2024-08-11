<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create(["name" => "admin"]);
        $clienteRole = Role::create(["name" => "cliente"]);
        //permisos para administrativos
        Permission::create(["name" => "administrar usuarios"])->assignRole($adminRole);
        Permission::create(["name" => "administrar roles"])->assignRole($adminRole);
        Permission::create(["name" => "administrar permisos"])->assignRole($adminRole);
        Permission::create(["name" => "administrar productos"])->assignRole($adminRole);
        Permission::create(["name" => "administrar inventarios"])->assignRole($adminRole);
        Permission::create(["name" => "administrar salidas"])->assignRole($adminRole);
        Permission::create(["name" => "administrar ordens"])->assignRole($adminRole);
        Permission::create(["name" => "administrar categorias"])->assignRole($adminRole);
        Permission::create(["name" => "administrar estados"])->assignRole($adminRole);
        Permission::create(["name" => "administrar metodos"])->assignRole($adminRole);
        Permission::create(["name" => "administrar pagos"])->assignRole($adminRole);

        //permisos para clientes
        Permission::create(["name" => "realizar pagos"])->assignRole($clienteRole);
        Permission::create(["name" => "realizar ordens"])->assignRole($clienteRole);
        Permission::create(["name" => "realizar pedidos"])->assignRole($clienteRole);
        Permission::create(["name" => "ver categorias"])->assignRole($clienteRole);
        Permission::create(["name" => "ver detalles"])->assignRole($clienteRole);
        Permission::create(["name" => "ver estados"])->assignRole($clienteRole);
        Permission::create(["name" => "ver pedidos"])->assignRole($clienteRole);


    }
}
