<?php

namespace App\Http\Controllers;

use App\Models\Dishes;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public static function getTopFood()
    {
        $food = array();
        $count = array();

        $result = Dishes::select('dish_name', DB::raw('COUNT(dish_name) as dish_count'))
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

    public static function getMonthlyData()
    {
        $monthlyData = [1 => array(), 2 => array(), 3 => array(), 4 => array(), 5 => array(), 6 => array(), 7 => array(), 8 => array(), 9 => array(), 10 => array(), 11 => array(), 12 => array()];

        $result = DB::table("Menu")
            ->join("dishes", "menu.id", "=", "dishes.menu_id")
            ->select(DB::raw('MONTH(menu.date) as month'), DB::raw("COUNT(dishes.dish_name) as dishcount"), "dishes.dish_name")
            ->groupBy("month", "dishes.dish_name")
            ->orderBy("dishcount", 'DESC')
            ->get();

        foreach ($result as $item) {
            array_push($monthlyData[$item->month], [$item->dish_name, $item->dishcount]);
        }
        return $monthlyData;
    }
}
