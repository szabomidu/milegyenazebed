<?php

use App\Http\Controllers\ChartController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    //\App\Http\Controllers\FakerController::createFakeData();
    $notSubscribedFood = SubscriptionController::getNotSubscribedFood();
    $monthlyData = ChartController::getMonthlyData();
    $topFood = ChartController::getTopFood();
    $subscriptions = SubscriptionController::getSubscriptions();
    if ($menu) {
        $dishes = $dishController->getDishesToMenu($menu->id);
        return view('home', ["date" => $menu->date, "dishes" => $dishes, "data" => $monthlyData, "topfood" => $topFood, "selectOptions" => $notSubscribedFood, "subscriptions" => $subscriptions]);
    } else {
        return view('home', ["date" => "No dishes for today yet", "dishes" => []]);
    }
})->name('home')->middleware(['auth']);

Route::post('/subscribe', function (Request $request) {
    SubscriptionController::subscribe($request);
    return redirect()->route('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
