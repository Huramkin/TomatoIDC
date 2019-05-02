<?php

namespace App\Console;

use App\Host;
use App\Http\Controllers\Bill\HourController;
use App\Http\Controllers\SetupController;
use App\Jobs\DelHost;
use App\Jobs\HealthCheck;
use App\Jobs\HourBill;
use App\Jobs\SuspendHost;
use App\Order;
use Carbon\Carbon;
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
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //按小时计费派发任务
        $schedule->call(function () {
            Host::where([
                ['status', 1],
                ['type', 'hour']
            ])->chunk(500, function ($hosts) {
                    HourBill::dispatch($hosts);
            });
        })->hourly();

        //机器过期
        $schedule->call(function () {
            Host::where([//过期暂停
                ['status', 1],
                ['deadline', '<=', Carbon::now()]
            ])->chunk(100, function ($hosts) {
                foreach ($hosts as $host) {
                    SuspendHost::dispatch($host);
                }
            });
            //永久删除
            $delTime = SetupController::getSetting('setting.expire.terminate.host.data') ?? 7;
            Host::where([
                ['status', 2],
                ['deadline', '<=', Carbon::now()->addDays($delTime)]
            ])->chunk(100, function ($hosts) {
                foreach ($hosts as $host) {
                    DelHost::dispatch($host);
                }
            });
        })->everyFiveMinutes();

        //检测支付
        $schedule->call(function () {
            Order::where(
                [
                    ['status', 1],
                    ['created_at', '>=', Carbon::now()->subHour()]
                ]
            )->chunk(100, function ($orders) {
                foreach ($orders as $order) {
                    DelHost::dispatch($order);
                }
            });
        })->everyMinute();

        $schedule->job(new HealthCheck)->daily();//健康检测
        // $schedule->command('inspire')
        //          ->hourly();
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
