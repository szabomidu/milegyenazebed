<?php

namespace App\Http\Controllers;

use App\Models\Dishes;
use App\Models\Menu;
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
            $menu = Menu::create([
                    'date' => $faker->dateTimeBetween("-1 years",'now')->format('Y.m.d'),
            ]);
            foreach(range(1,25) as $a) {
                Dishes::create([
                    'dish_name' => $faker->foodName(),
                    'is_new' => $faker->boolean,
                    'menu_id' => $menu->id,
                ]);
            }
        }

    }
}
