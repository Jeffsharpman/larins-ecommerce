<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
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

        if (User::where('email', 'superadmin@example.com')->doesntExist()) {
            $superAdmin = User::factory()->create([
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'password' => bcrypt('password'),
            ]);
            $superAdmin->assignRole('super_admin');
        }

        if (User::where('email', 'admin@example.com')->doesntExist()) {
            $admin = User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
            ]);
            $admin->assignRole('admin');
        }

        if (User::where('email', 'test@example.com')->doesntExist()) {
            $customer = User::factory()->create([
                'name' => 'Regular Customer',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]);
            $customer->assignRole('user');
        }
    }
}
