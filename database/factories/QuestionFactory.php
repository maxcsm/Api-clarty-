<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'question' => $this->faker->realText(25),
            'answer1' => $this->faker->realText(10),
            'answer2' => $this->faker->realText(10),
            'answer3' => $this->faker->realText(10),
            'answer4' => $this->faker->realText(10),
            'answer5' => $this->faker->realText(10),
            'category'=> 'post',
            'view' => rand(0, 1),
            'edited_by'=> rand(1, 10),
          //  'image' => $this->faker->image('storage_path',640,480, null, false)
        ];
    }
}
