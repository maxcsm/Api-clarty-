<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Items>
 */
class ItemsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
       
            return [
                
                'idinvoice' => rand(1, 10),
                'title' => $this->faker->word,
                'content'=> $this->faker->catchPhrase,
                'qte'=> rand(1, 3),
                'price' => rand(1, 50)
                
                //'image' => $this->faker->image('public/storage/images',640,480, null, false)
            ];
        }
    
}
