<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_date'=>$this->faker->dateTimeBetween('2021-01-01','2021-09-16'),
            'order_status'=>$this->faker->randomElement(['pending', 'accepted', 'invoiced', 'dispatched','rejected']),
            'promotion_code'=>$this->faker->citySuffix(),
            'customer_id'=>Customer::inRandomOrder()->first()->id
        ];
    }
}
