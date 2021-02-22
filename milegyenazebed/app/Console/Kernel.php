<?php

namespace App\Console;

use App\Http\Controllers\MenuController;
use App\Http\Controllers\DishController;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $menuController = new MenuController();
            $dishController = new DishController();
            $menuData = $dishController->getMenuFromWebsite();
            $date = $menuController->getMenuDateFromWebsite();
            $menuId = $menuController->saveMenuDateToDatabaseReturningId($date[0]);
            $dishController->saveMenuToDatabase($menuData, $menuId);
        })->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
