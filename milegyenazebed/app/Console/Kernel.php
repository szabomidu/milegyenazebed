<?php

namespace App\Console;

use App\Http\Controllers\MenuController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\MessageController;
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
            $menuInDB = $menuController->checkIfMenuExists($date[0]);
            if($menuInDB === null) {
                $menuId = $menuController->saveMenuDateToDatabaseReturningId($date[0]);
                $dishController->saveMenuToDatabase($menuData, $menuId);
            }
        })->hourly();
        $messageController = new MessageController();
        $text = $messageController->composeMattermostMessage();
        $command = 'curl -i -X POST -H \'Content-Type: application/json\' -d \'{"text": "' . $text . '" }\' https://mattermost.xdroid.com/hooks/j5nba3i64bdpfny19k55uxczpo';
        $schedule->exec($command)->hourly();
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
