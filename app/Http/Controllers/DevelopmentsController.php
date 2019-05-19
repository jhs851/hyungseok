<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DevelopmentsController extends Controller
{
    public function index()
    {
        return view('developments.index');
    }
}
