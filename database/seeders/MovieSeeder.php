<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Movie;
use App\Models\Country;
use App\Models\Actor;
use App\Models\Genre;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 10; $i++) { 
            Movie::factory(1)->
            hasAttached(Country::all()->random(random_int(1, 4)))->
            hasAttached(Actor::all()->random(random_int(3, 7)))->
            hasAttached(Genre::all()->random(random_int(1, 4)))->
            create();
        }
    }
}
