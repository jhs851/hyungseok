<?php

namespace App\Core;

use App\Http\Requests\DevelopmentRequest;
use App\Models\Development;

trait DevelopmentService
{
    /**
     * 새로 생성된 리소스를 저장소에 저장합니다.
     *
     * @param  DevelopmentRequest  $request
     * @return mixed
     */
    public function store(DevelopmentRequest $request)
    {
        $development = $request->user()->developments()->create($request->all());

        $development->tags()->sync($request->input('tags'));

        flash()->success(trans('developments.store'));

        return $this->stored($development) ?:
            redirect(route('admin.developments.show', $development->id));
    }

    public function stored(Development $development)
    {

    }
}