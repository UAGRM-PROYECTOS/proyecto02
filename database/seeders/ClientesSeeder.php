<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name" => "Christian Gutierrez",
            "email" => "christian@gmail.com",
            "password" => bcrypt("1234567890"),
            "telefono" => "78050589",
            "direccion" => "Av Brasil , Calle Rivero #02",
            "sexo" => "M",
            "ci_nit" => "1234567"
        ])->assignRole("cliente");

        User::create([
            "name" => "Juan Carlos",
            "email" => "juancarlos@gmail.com",
            "password" => bcrypt("1234567890"),
            "telefono" => "78050599",
            "direccion" => "Av Brasil , Calle Rivero #05",
            "sexo" => "M",
            "ci_nit" => "1234568"
        ])->assignRole("cliente");
    }
}
