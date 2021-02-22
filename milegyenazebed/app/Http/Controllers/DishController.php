<?php

namespace App\Http\Controllers;

use App\Models\Dishes;
use Goutte\Client;
use Illuminate\Support\Facades\DB;

class DishController extends Controller
{
    private $client;
    private $crawler;
    private $menuData = array();

    public function __construct()
    {
        $this->client = new Client();
        $this->crawler = $this->client->request('GET', "http://arco-s.com/");
    }

    public function getMenuFromWebsite(): array
    {
        $this->crawler->filter('.woocommerce-loop-product__title')->each(function ($node) {
            array_push($this->menuData, $node->text());
        });
        return $this->menuData;
    }

    public function saveMenuToDatabase($menuData, $menuId)
    {
        foreach ($menuData as $menuItem) {
            $dishInDB = DB::table("dishes")->where('dish_name', $menuItem);
            if ($dishInDB === null) {
                DB::table("dishes")
                    ->where('dish_name', $menuItem)
                    ->update(['is_new' => 0]);
            } else {
                DB::table("dishes")
                    ->insert([
                        'dish_name' => $menuItem,
                        'is_new' => true,
                        'menu_id' => $menuId,
                    ]);
            }
        }
    }

    public function getDishesToMenu($menuId)
    {
        return DB::table("dishes")
            ->where('menu_id', $menuId)
            ->get();
    }
}
