<?php

namespace App\Http\Controllers;

use App\Models\Dishes;
use Goutte\Client;

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
        DB::table("dishes")
            ->delete();
        foreach ($menuData as $menuItem) {
            DB::table("dishes")
                ->insert([
                    'dish_name' => $menuItem,
                    'is_new' => true,
                    'menu_id' => $menuId,
                ]);
        }
    }

    }
}
