<?php

namespace App\Http\Controllers;

use App\Jobs\ScreenshotJob;
use App\Models\Screenshot;
use Illuminate\Http\Request;
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
        request()->validate(['url' => 'required|min:3']);
        $randname = Str::random(10);
        ScreenshotJob::dispatch(request('url'), $randname);
        toastr()->info('Screenshot was created successfully!', 'Successful!');
        Screenshot::create(['name' => $randname.'.png']);
        return redirect('/');
    }
}
