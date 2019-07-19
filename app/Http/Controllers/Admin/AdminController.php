<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * @return View
     */
    public function __invoke() : View
    {
        return view('admin.dashboard');
    }
}
