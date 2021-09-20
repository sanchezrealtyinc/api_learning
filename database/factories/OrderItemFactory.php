<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'unit_price'=>$this->faker->randomFloat(2,1,100),
            'quantity'=>$this->faker->numberBetween(1,5),
            'order_id'=>Order::inRandomOrder()->first()->id,
            'product_id'=>Product::inRandomOrder()->first()->id 
        ];
    }
}
