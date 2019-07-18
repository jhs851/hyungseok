<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadImageRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class UploadImagesController extends Controller
{
    /**
     * 전달 받은 이미지를 저장하고 경로를 반환합니다.
     *
     * @param  UploadImageRequest  $request
     * @return JsonResponse
     */
    public function store(UploadImageRequest $request) : JsonResponse
    {
        return response()->json([
            'message' => trans('developments.uploaded_image'),
            'path' => Storage::url($request->file('image')->store('images')),
        ]);
    }
}
