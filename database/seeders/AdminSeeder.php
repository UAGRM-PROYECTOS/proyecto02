<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name" => "Admin",
            "email" => "testapp1715@gmail.com",
            "password" => bcrypt("password"),
        ])->assignRole("admin");

        User::create([
            "name" => "Alison Tacoo Maturano",
            "email" => "alison@gmail.com",
            "password" => bcrypt("1234567890"),
        ])->assignRole("admin");

    }
}
