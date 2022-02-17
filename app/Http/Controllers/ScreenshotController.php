<?php

namespace App\Http\Controllers;

use App\Jobs\ScreenshotJob;
use App\Models\Screenshot;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;

class ScreenshotController extends Controller
{
    public function index()
    {
        $screenshots = Screenshot::orderBy('created_at', 'desc')->get();

        return view('welcome', compact('screenshots'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|min:2'
        ]);

        $url = strpos($request->get('url'), '.') == false ? $request->get('url') . '.com' : $request->get('url');

        if (Str::substr($url, 0, 4) != 'http') {
            $url = 'https://' . $url;
        }

        ScreenshotJob::dispatchSync($url);

        toastr()->info('Screenshot was successfully created!', 'Successful!');

        return redirect('/');
    }
}
