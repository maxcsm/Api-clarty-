<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class PageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Page::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->realText(25),
            'subtitle' => $this->faker->realText(25),
            'content'=> $this->faker->realText(),
            'category'=> 'page',
            'view' => rand(0, 1),
            'edited_by'=> rand(1, 10),
          //  'image' => $this->faker->image('storage_path',640,480, null, false)
        ];
    }
}
