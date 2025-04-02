<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario administrador
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('12345678'), 
        ]);
        $admin->assignRole('administrador');

        // Crear usuario abogado
        $abogado = User::create([
            'name' => 'Abogado User',
            'email' => 'abogado@example.com',
            'password' => Hash::make('12345678'),
        ]);
        $abogado->assignRole('abogados');

        // Crear usuario cliente
        $cliente = User::create([
            'name' => 'Cliente User',
            'email' => 'cliente@example.com',
            'password' => Hash::make('12345678'), 
        ]);
        $cliente->assignRole('clientes');
    }
}
