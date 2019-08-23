<?php

namespace App\Core;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

trait NumericalStatementable
{
    /**
     * 주어진 월에 해댕하는 개발 포스트 Builder를 반환합니다.
     *
     * @param Builder     $query
     * @param Carbon|null $date
     * @return Builder
     */
    public function scopeMonthlies(Builder $query, Carbon $date = null): Builder
    {
        if (is_null($date)) {
            $date = Carbon::now();
        }

        return $query
            ->whereYear('created_at', '=', $date->year)
            ->whereMonth('created_at', '=', $date->month);
    }

    /**
     * 일별로 그룹화하고 해당 날짜에 해당하는 포스트의 수를 반환하는 Builder를 반환합니다.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeCountsByDays(Builder $query): Builder
    {
        return $query->monthlies()
            ->selectRaw(app()->environment('testing')
                ? 'strftime("%d", `created_at`) as day'
                : 'DAY(created_at) as day')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('day')
            ->orderBy('day', 'asc');
    }

    /**
     * Eager 로딩 되는 관계들을 제거하고 엘로퀀트 쿼리 빌더를 반환합니다.
     *
     * @return Builder
     */
    public static function withoutAll(): Builder
    {
        return static::without((new static)->with);
    }
}
