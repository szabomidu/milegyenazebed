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

    public static function getSubscriberToDish($dish)
    {
        $subscribers = array();

        $subscriptions = Subscription::select('username', 'dish_name')
            ->get();

        foreach ($subscriptions as $subscription) {
            if (strpos($dish, strtolower($subscription->dish_name)) !== false) {
                array_push($subscribers, $subscription->username);
            }
        }

        return $subscribers;
    }

    public static function getSubscriptions()
    {
        $id = Auth::id();

        return Subscription::select('id', 'dish_name')
            ->where('user_id', $id)
            ->get();
    }

    public static function unSubscribe(Request $request)
    {
        $id = $request->id;

        return Subscription::where('id', $id)
            ->delete();
    }
}
