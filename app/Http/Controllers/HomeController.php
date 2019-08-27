<?php

namespace App\Http\Controllers;

use App\Models\Development;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('home.index', [
            'developments' => Development::latest()->limit(3)->get(),
        ]);
    }
}
