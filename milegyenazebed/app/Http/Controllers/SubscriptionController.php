<?php

namespace App\Http\Controllers;

use App\Models\Dishes;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public static function getNotSubscribedFood()
    {
        $subscribedFoodArray = array();
        $id = Auth::id();
        $subscribedFood = Subscription::select('dish_name', "username", "user_id")
            ->where('user_id', $id)
            ->get();

        foreach ($subscribedFood as $food) {
            array_push($subscribedFoodArray, $food->dish_name);
        }

        $notSubscribedFood = Dishes::select('dish_name')
            ->whereNotIn('dish_name', $subscribedFoodArray)
            ->distinct()
            ->orderBy('dish_name')
            ->get();

        return $notSubscribedFood;
    }

    public static function subscribe(Request $request)
    {
        $value = $request->subscription;
        $id = Auth::id();
        $username = Auth::user();

        Subscription::create([
            "dish_name" => $value,
            "username" => $username->name,
            "user_id" => $id
        ]);
    }

    public static function getSubscriberToDish($dish_name)
    {
        return Subscription::select('username')
            ->where('dish_name', "=", $dish_name)
            ->get();
    }
}
