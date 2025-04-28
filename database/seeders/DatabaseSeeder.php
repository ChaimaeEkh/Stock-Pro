<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Order;
use App\Models\Stock;
use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{

    protected $categories = [
        'Laptops',
        'Smartphones',
        'Tablets',
        'Desktop Computers',
        'Computer Monitors',
        'Keyboards',
        'Computer Mice',
        'Headphones',
        'Printers & Scanners',
        'Smart Watches',
        'Webcams',
        'Speakers',
        'External Hard Drives',
        'USB Flash Drives',
        'Chargers & Cables'
    ];


    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),  
            'role' => 'admin',
        ]);

     // Create categories from predefined list
     $categories = collect($this->categories)->map(function ($name) {
        return Category::create(['name' => $name]);
    });

    // Create base data
    $suppliers = Supplier::factory(10)->create();
    $stores = Store::factory(5)->create();

    // Create products with existing suppliers and categories
    $products = Product::factory(50)
        ->recycle($suppliers)
        ->recycle($categories)
        ->create();

    // Create stocks for products in stores
    Stock::factory(100)
        ->recycle($products)
        ->recycle($stores)
        ->create();

    // Create customers and their orders
    $customers = Customer::factory(20)->create();
    $orders = Order::factory(30)
        ->recycle($customers)
        ->create();

    // Create transactions for orders and stocks
    Transaction::factory(50)->create();
    //create folders for stockage
    Storage::disk('public')->makeDirectory('avatars');

    $this->command->info('Dossiers de stockage créés aveac succès!');
}
}
