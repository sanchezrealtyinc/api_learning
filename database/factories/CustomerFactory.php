<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_name'=>$this->faker->text(10),
            'job_title'=>$this->faker->text(10),
            'departament'=>$this->faker->text(15),
            'limit_credit'=>$this->faker->text(10),
            'person_id'=>Person::inRandomOrder()->first()->id 
        ];
    }
}
