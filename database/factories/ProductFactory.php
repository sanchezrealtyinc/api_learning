<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->text(10),
            'description'=>$this->faker->text(20),
            'weight_class'=>$this->faker->randomElement(['pounds','grams','kilograms','ounces']), /*libras-pounds gramos-grams kilogramos-kilograms onzas-ounces*/
            'minimun_price'=>$this->faker->randomFloat(2,1,100),
            'price_currency'=>$this->faker->randomElement(['dolar','lempira','euro']),
            'category_id'=>Category::inRandomOrder()->first()->id 
        ];
    }
}
