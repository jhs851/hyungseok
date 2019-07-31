<?php

namespace App\Services;

use App\Http\Requests\DevelopmentRequest;
use App\Models\Development;
use Exception;
use Illuminate\Foundation\Auth\RedirectsUsers;

trait DevelopmentsService
{
    use RedirectsUsers;

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

        return $this->stored($request, $development) ?:
            redirect($this->redirectPath());
    }

    /**
     * 리소스를 저장한 후에 응답입니다.
     *
     * @param  DevelopmentRequest  $request
     * @param  Development  $development
     * @return mixed
     */
    public function stored(DevelopmentRequest $request, Development $development)
    {
        //
    }

    /**
     * 스토리지에서 지정된 리소스를 업데이트합니다.
     *
     * @param  DevelopmentRequest  $request
     * @param  Development  $development
     * @return mixed
     */
    public function update(DevelopmentRequest $request, Development $development)
    {
        $development->update($request->all());

        $development->tags()->sync($request->input('tags'));

        return $this->updated($request, $development) ?:
            redirect($this->redirectPath());
    }

    /**
     * 리소스를 업데이트 한 후에 응답입니다.
     *
     * @param  DevelopmentRequest  $request
     * @param  Development  $development
     * @return mixed
     */
    public function updated(DevelopmentRequest $request, Development $development)
    {
        //
    }

    /**
     * 지정된 리소스를 스토리지에서 제거합니다.
     *
     * @param  Development  $development
     * @return mixed
     * @throws Exception
     */
    public function destroy(Development $development)
    {
        $development->delete();

        flash()->success(trans('developments.deleted'));

        return $this->destroyed($development) ?:
            redirect($this->redirectPath());
    }

    /**
     * 리소스를 제거 한 후에 응답입니다.
     *
     * @param  Development  $development
     * @return mixed
     */
    public function destroyed(Development $development)
    {
        //
    }
}
