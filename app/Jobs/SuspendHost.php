<?php

namespace App\Jobs;

use App\Host;
use App\Http\Controllers\Server\ServerPluginController;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SuspendHost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $host;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Host $host)
    {
        $this->host = $host;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!$this->host->isEmpty()) {
            $server = $this->host->order->good->server;
            $serverController = new ServerPluginController();
            $status = $serverController->closeHost($server, $this->host);
            if ($status) {
                Host::where('id', $this->host->id)->update(['status' => 2]);//标记已停用
            } else {
                Host::where('id', $this->host->id)->update(['status' => 3]);//标记出错
            }
        }
    }
}
