<?php

namespace Database\Factories;

use App\Models\location;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{


    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = location::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()



    {


     
    return [
            //
         
            'title' => $this->faker->realText(25),
            'subtitle' => $this->faker->realText(25),
            'content'=> $this->faker->realText(25),
            'category'=> 'location',
            'city' =>  $this->faker->city(10),
           // 'zip' =>  $this->$faker->postcode(5),
           'country' => $this->faker->city(10),
           'lat' => '46.5196535',
           'lng' => '6.6322734',
            'view' => rand(0, 1),
            'edited_by'=> rand(1, 10),

          //  'image' => $this->faker->image('storage_path',640,480, null, false)
        ];
    }
}
