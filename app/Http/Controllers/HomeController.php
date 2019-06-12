<?php

namespace App\Http\Controllers;

use App\Models\Development;

class HomeController extends Controller
{
    public function __invoke()
    {
        return view('home.index', [
            'developments' => Development::latest()->get(),
        ]);
    }
}
