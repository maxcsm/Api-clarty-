<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoices>
 */
class InvoicesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
                
            'CustomerID' => rand(1, 10),
            'ItemName' => "",
            'ItemDesc'=> "",
            'ItemPrice'=> 0,
            'ItemTotal' => 0,
            'DueDate' => $this->faker->dateTime($max = 'now'),
            'Quantity' => 0,
            'ItemTotal' => 0,
            'InvoiceDate' => $this->faker->dateTime($max = 'now'),
            'InvoiceID' => rand(1, 50),
            'InvoiceNumber' => rand(1, 50),
            'ItemTax1' =>20,
            'Total' =>20,
            'ItemTax1Amount' => 20,
            'InvoiceStatus' => 0
            //'image' => $this->faker->image('public/storage/images',640,480, null, false)
        ];
}

}
