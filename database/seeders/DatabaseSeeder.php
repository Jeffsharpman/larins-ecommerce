<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

     Category::factory(4)->create();
        Brand::factory(4)->create();
        Product::factory(20)->create();

       // 1. MUST run this first to create roles and permissions in the DB
    $this->call(RoleAndPermissionSeeder::class);

    // 2. NOW you can create users and assign those roles
    $superAdmin = User::factory()->create([
        'name' => 'Super Admin',
        'email' => 'superadmin@example.com',
        'password' => bcrypt('password'),
    ]);

    $superAdmin->assignRole('super_admin');

    $admin = User::factory()->create([
        'name' => 'Admin',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
    ]);

    $admin->assignRole('admin');
    
    // Create a regular customer
    $customer = User::factory()->create([
        'name' => 'Regular Customer',
        'email' => 'test@example.com',
    ]);
    
    $customer->assignRole('user');

       
    }
}
