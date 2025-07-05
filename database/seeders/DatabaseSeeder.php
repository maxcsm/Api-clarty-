<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {


        \App\Models\User::factory(200)->create();
        \App\Models\Post::factory(11)->create();
        \App\Models\Page::factory(11)->create();
        \App\Models\Appointement::factory(200)->create();
        \App\Models\Question::factory(11)->create();
        \App\Models\Survey::factory(11)->create();
        \App\Models\Questionlist::factory(11)->create();
        \App\Models\Product::factory(11)->create();
        \App\Models\Location::factory(150)->create();
        \App\Models\Project::factory(11)->create();
        \App\Models\Items::factory(18)->create();
        \App\Models\Invoices::factory(11)->create();
        \App\Models\Tags::factory(11)->create();
      //  \App\Models\Timer::factory(11)->create();
        // \App\Models\User::factory(10)->create();

         \App\Models\User::factory()->create([
           //  '' => 'Test User',
          'email' => 'demo@example.com',
           ]);
    }
}
