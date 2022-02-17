<?php

namespace App\Jobs;

use App\Models\Screenshot;
use Illuminate\Bus\Queueable;
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

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function handle()
    {
        $imgName = (string) Str::uuid() . '.png';

        Browsershot::url($this->url)
            ->setNodeBinary(env('NODE_PATH', '/usr/local/bin/node'))
            ->setNpmBinary(env('NPM_PATH', '/usr/local/bin/npm'))
            ->noSandbox()
            ->setDelay(1000)
            ->timeout(10)
            ->save('img/' . $imgName . '');

        Screenshot::create([
            'name' => $imgName
        ]);
    }
}
