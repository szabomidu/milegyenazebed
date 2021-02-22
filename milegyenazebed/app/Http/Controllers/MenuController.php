<?php

namespace App\Http\Controllers;

use Goutte\Client;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    private $client;
    private $crawler;

    public function __construct()
    {
        $this->client = new Client();
        $this->crawler = $this->client->request('GET', "http://arco-s.com/");
    }

    public function getMenuDateFromWebsite(): array
    {
        return $this->crawler->filter('.section-title')->each(function ($node) {
            if ($node->text() != "Nyitvatartás" && $node->text() != "Asztalfoglalás") {
                return $node->text();
            }
        });
    }


    public function saveMenuDateToDatabaseReturningId($date)
    {
        $menu = DB::table("menu")
            ->where('date', $date)
            ->first();
        if ($menu === null) {
            return DB::table('menu')->insertGetId(['date' => $date]);
        }
        return $menu->id;
    }
}
