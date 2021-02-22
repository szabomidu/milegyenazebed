<?php

use App\Http\Controllers\DishController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $menuController = new MenuController();
    $dishController = new DishController();
    $menu = $menuController->getMenuDateAndId(date("Y.m.d"));
    if ($menu) {
        $dishes = $dishController->getDishesToMenu($menu->id);
        return view('home', ["date" => $menu->date, "dishes" => $dishes]);
    }
})->name('home');

Route::get('/register', function (){
    return view('registration');
});

Route::post('/register', 'App\Http\Controllers\UserController@store')->name('register');

Route::get('/login', function (){
    return view('login');
})->name('login');

Route::post('/login', 'App\Http\Controllers\UserController@login');
