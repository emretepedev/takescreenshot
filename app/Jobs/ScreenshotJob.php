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
    public $imgName;

    public function __construct($url, $imgName)
    {
        $this->url = $url;
        $this->imgName = $imgName;
    }

    public function handle()
    {
        $this->takeScreenshot($this->url, $this->imgName);
    }

    public function takeScreenshot($url, $imgName)
    {
        $url = strpos($url, '.') == false ? $url . '.com' : $url;
        Str::substr($url, 0, 4) != 'http' ? $url = 'http://' . $url : '';
        Browsershot::url($url)
            ->setNodeBinary('/usr/local/bin/node')
            ->setNpmBinary('/usr/local/bin/npm')
            ->noSandbox()
            ->setDelay(1000)
            ->timeout(10)
            ->save('img/' . $imgName . '.png');
    }
}
