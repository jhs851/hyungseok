<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Development;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
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
        $developments = Development::orderBy('created_at', 'desc')->get();
        [$isIncrease, $percentage] = $this->comparison();
        $thisMonthDevelopments = $this->getThisMonthDevelopments();
        $groups = $this->getThisMonthDevelopments()->groupBy(function (Development $development) {
            return $development->created_at->day;
        });

        return view('admin.developments.index', compact('developments', 'isIncrease', 'percentage', 'thisMonthDevelopments'));
    }

    /**
     * 지난달과 이번달의 개발 블로그 수를 비교 합니다.
     *
     * @return array
     */
    protected function comparison() : array
    {
        $lastMonthDevelopmentsCount = Development::whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->count() ?: 1;
        $thisMonthDevelopmentsCount = $this->getThisMonthDevelopments()->count();

        return [
            $thisMonthDevelopmentsCount - $lastMonthDevelopmentsCount >= 0,
            sprintf('%.2f', max($thisMonthDevelopmentsCount, $lastMonthDevelopmentsCount) / min($thisMonthDevelopmentsCount, $lastMonthDevelopmentsCount) * 10),
        ];
    }

    /**
     * 이번 달에 작성된 개발 포스트를 반환합니다.
     *
     * @return Collection
     */
    protected function getThisMonthDevelopments() : Collection
    {
        return Development::whereMonth('created_at', '=', Carbon::now()->month)->get();
    }
}
