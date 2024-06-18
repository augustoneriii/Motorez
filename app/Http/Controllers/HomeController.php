<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    /**
     * Serve a JavaScript file from the resources directory.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $filename
     * @return \Illuminate\Http\Response
     */
    public function serveJs(Request $request, $filename)
    {
        $path = resource_path('js/' . $filename);

        if (!File::exists($path)) {
            abort(404, 'JavaScript file not found.');
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
}
