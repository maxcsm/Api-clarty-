<?php

namespace Database\Factories;

use App\Models\tags;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = tags::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [



            'tag_fr' => $this->faker->realText(10),
            'tag_en' => $this->faker->realText(10),
            'tag_de'=> $this->faker->realText(10),
            'isChecked' => rand(0, 1),
            //
        ];
    }
}
