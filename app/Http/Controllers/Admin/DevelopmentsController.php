<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Development;
use Illuminate\View\View;

class DevelopmentsController extends Controller
{
    /**
     * 리소스 목록을 표시합니다.
     *
     * @return View
     */
    public function index() : View
    {
        $developmentsCount = Development::count();
        $monthliesCount = Development::monthlies()->count();
        $incremental = parseFloat($monthliesCount / $developmentsCount * 100);
        $countsByDays = Development::withoutAll()->countsByDays()->get();
        $mostVisited = Development::withoutAll()->orderBy('visits', 'desc')->first();

        return view('admin.developments.index', compact('developmentsCount', 'monthliesCount', 'incremental', 'countsByDays', 'mostVisited'));
    }
}
