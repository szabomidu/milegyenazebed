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
        $message = "    ## Napi menü - $menu->date \n";
        foreach ($dishes as $dish){
            if ($dish->dish_name === "Lencsefőzelék" || $dish->dish_name === "LENCSEFŐZELÉK"){
                $status = "LEGJOBB!!";
            } else {
                $status = $dish->is_new === 1 ? "ÚJ" : "";
            }
            $message .= "* $status $dish->dish_name\n";
        }
        return $message;
    }
}