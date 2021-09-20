<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            PersonSeeder::class,
            EmploymentSeeder::class,
            CustomerSeeder::class,
            SupplierSeeder::class,
            LocationSeeder::class,
            WarehouseSeeder::class,
            InventorySeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class
        ]);
    }
}
