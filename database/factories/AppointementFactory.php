<?php

namespace Database\Factories;

use App\Models\Appointement;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Appointement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'=> rand(1,10),
            'title' => "Rendez-vous",
            'content'=> $this->faker->realText(25),
            'start_at'=>$this->faker->dateTime($max = 'now'),
            'end_at'=>$this->faker->dateTime($max = 'now'),
            'state'=> rand(0, 1),
            'view' => rand(0, 1),
            'edited_by'=> rand(1, 10),
            //'image' => $this->faker->image('storage_path',640,480, null, false)
        ];
    }
}
