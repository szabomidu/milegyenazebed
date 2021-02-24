<?php

namespace App\Http\Controllers;

class MessageController extends Controller
{
    public function composeMattermostMessage(): string
    {
        $menuController = new MenuController();
        $dishController = new DishController();
        $menu = $menuController->getMenuDateAndId(date("Y.m.d"));
        $dishes = $dishController->getDishesToMenu($menu->id);
        $message = "## :warning: Napi menü - $menu->date :warning: \n";
        foreach ($dishes as $dish){
            $subscribers = SubscriptionController::getSubscriberToDish($dish->dish_name);
            if ($dish->dish_name === "Lencsefőzelék" || $dish->dish_name === "LENCSEFŐZELÉK"){
                $status = "LEGJOBB!!";
            } else {
                $status = $dish->is_new ? "ÚJ " : "";
            }
            $message .= "* " . $status . ucfirst(strtolower($dish->dish_name)) . " ";
            foreach ($subscribers as $subscriber){
                $message .= " @$subscriber->username ";
            }
            $message .= "\n";
        }
        return $message;
    }
}
