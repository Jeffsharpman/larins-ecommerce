<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Page;
use App\Models\Product;
use App\Models\Review;
use App\Models\ShippingMethod;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Category::factory(4)->create();
        Brand::factory(4)->create();
        Product::factory(20)->create();

        $this->call(RoleAndPermissionSeeder::class);

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

        $customer = User::factory()->create([
            'name' => 'Regular Customer',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
        $customer->assignRole('user');

        $customers = User::factory(10)->create();
        $customers->each(fn ($user) => $user->assignRole('user'));

        ShippingMethod::factory(4)->create();

        Coupon::factory(5)->create();

        Announcement::factory(2)->create();

        Page::factory(4)->create();

        $products = Product::all();
        foreach ($products as $product) {
            Review::factory(rand(0, 5))->create([
                'product_id' => $product->id,
                'user_id' => User::whereHas('roles', fn ($q) => $q->where('name', 'user'))->inRandomOrder()->first()->id,
            ]);
        }
    }
}
