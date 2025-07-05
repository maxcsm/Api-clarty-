<?php

namespace Database\Factories;

use App\Models\questionlist;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class QuestionlistFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = questionlist::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'questions' => 2,
            'surveys' => 1,
            //
        ];
    }
}
