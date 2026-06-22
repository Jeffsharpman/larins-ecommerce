<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class ProductionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        if (! User::query()->where('email', '=', 'superadmin@example.com', 'and')->exists()) {
            $user = User::factory()->create([
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'password' => Hash::make('password'),
            ]);
            $user->assignRole('super_admin');
        }

        if (! User::query()->where('email', '=', 'admin@example.com', 'and')->exists()) {
            $user = User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
            ]);
            $user->assignRole('admin');
        }

        if (! User::query()->where('email', '=', 'test@example.com', 'and')->exists()) {
            $user = User::factory()->create([
                'name' => 'Regular Customer',
                'email' => 'test@example.com',
                'password' => Hash::make('password'),
            ]);
            $user->assignRole('user');
        }
    }
}
