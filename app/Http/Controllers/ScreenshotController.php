<?php

namespace App\Http\Controllers;

use App\Jobs\ScreenshotJob;
use App\Models\Screenshot;
use Illuminate\Support\Str;


class ScreenshotController extends Controller
{
    public function index()
    {
        $screenshots = Screenshot::orderBy('created_at', 'desc')->get();

        return view('welcome', compact('screenshots'));
    }

    public function store()
    {
        request()->validate([
            'url' => 'required|min:3'
        ]);

        $imgName = Str::random(50);
        ScreenshotJob::dispatch(request('url'), $imgName);

        Screenshot::create([
            'name' => $imgName.'.png'
        ]);

        toastr()->info('Screenshot was successfully created!', 'Successful!');

        return redirect('/');
    }
}
