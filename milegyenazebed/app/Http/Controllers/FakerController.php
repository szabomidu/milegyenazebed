<?php

namespace App\Http\Controllers;

use App\Models\Dishes;
use Faker\Factory;
use FakerRestaurant\Provider\en_US\Restaurant;
use Illuminate\Support\Facades\DB;

class FakerController extends Controller
{
    public static function createFakeData()
    {
        $faker = Factory::create();
        $faker->addProvider(new Restaurant($faker));
        foreach (range(1, 50) as $item) {
            $id = DB::table('menu')
            ->insertGetId([
                'date' => $faker->date($format = 'Y.m.d', $max = 'now'),
            ]);
            foreach(range(1,25) as $a) {
                Dishes::create([
                    'dish_name' => $faker->foodName(),
                    'is_new' => $faker->boolean,
                    'menu_id' => $id,
                ]);
            }
        }

    }
}
