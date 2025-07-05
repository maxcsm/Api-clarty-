<?php

namespace Database\Factories;

use App\Models\product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word,
            'content'=> $this->faker->catchPhrase,
            'category'=> 'Produit',
             'ref'=> $this->faker->ean13,
             'width' => rand(1, 50),
             'height' => rand(1, 50),
             'weight' => rand(1, 50),
             'price' => rand(1, 2000),
             'view' => rand(0, 1),
             'edited_by'=> rand(1, 50),
            //'image' => $this->faker->image('public/storage/images',640,480, null, false)
        ];
    }
}
