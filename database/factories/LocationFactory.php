<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Location::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'country'=>$this->faker->country(),
            'city'=>$this->faker->city(),
            'state'=>$this->faker->text(15),
            'postal_code'=>$this->faker->postcode(),
            'address'=>$this->faker->address(),
        ];
    }
}
