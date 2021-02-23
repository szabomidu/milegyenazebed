<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public static function getTopFood()
    {
        $food = array();
        $count = array();

        $result = DB::table('dishes')
            ->select('dish_name', DB::raw('COUNT(dish_name) as dish_count'))
            ->groupBy('dish_name')
            ->orderBy(DB::raw('COUNT(dish_name)'), 'DESC')
            ->take(15)
            ->get();

        foreach ($result as $item){
            array_push($food, $item->dish_name);
            array_push($count, $item->dish_count);
        }

        return ["food" => $food, "numbers" => $count];
    }
}
