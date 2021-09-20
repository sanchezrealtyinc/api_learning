<?php

namespace Database\Factories;

use App\Models\Employment;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmploymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'work_position'=>$this->faker->name(),
            'job_title'=>$this->faker->text(10),
            'salary'=>$this->faker->randomFloat(2,1,100),
            'person_id'=>Person::inRandomOrder()->first()->id
        ];
    }
}
