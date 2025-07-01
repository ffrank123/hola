<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        // Crear roles si no existen
        $roles = ['superadmin', 'turista', 'emprendedor'];
        $guards = ['web', 'sanctum'];
        foreach ($roles as $role) {
            foreach ($guards as $guard) {
                $created = \Spatie\Permission\Models\Role::updateOrCreate([
                    'name' => $role,
                    'guard_name' => $guard
                ]);
                echo "Role creado: {$role} para guard: {$guard}\n";
            }
        }

        // Verificar si el usuario ya existe, si no lo crea
        $user = User::firstOrCreate([
            'email' => 'fkanachullo12@gmail.com', // El correo con el que se quiere loguear
        ], [
            'name' => 'Super Admin', // Nombre del usuario
            'password' => Hash::make('fraykana10'), // Contraseña para el superadmin
        ]);

        // Asignar el rol de superadmin al usuario
        $user->assignRole('superadmin');
    }
}
