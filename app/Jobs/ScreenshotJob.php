<?php

namespace App\Jobs;

use App\Models\Screenshot;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;

class ScreenshotJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $url;
    public $randname;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($url, $randname)
    {
        $this->url = $url;
        $this->randname = $randname;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->takeScreenshot($this->url, $this->randname);
    }

    public function takeScreenshot($url, $randname)
    {
        $url = strpos($url, '.') == false ? $url.'.com' : $url;

        Str::substr($url, 0, 4) != 'http' ? $url = 'http://'.$url : '';

        Browsershot::url($url)->save('img/'.$randname.'.png');
    }
}
