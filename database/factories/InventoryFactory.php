<?php

namespace Database\Factories;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Inventory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'quantity_on_hand'=>$this->faker->numberBetween(1,20),
            'quantity_available'=>$this->faker->numberBetween(1,30),
            'warehouse_id'=>Warehouse::inRandomOrder()->first()->id,
            'product_id'=>Product::inRandomOrder()->first()->id  
        ];
    }
}
