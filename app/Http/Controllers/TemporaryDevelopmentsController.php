<?php

namespace App\Http\Controllers;

use App\Http\Requests\TemporaryDevelopmentRequest;
use App\Models\TemporaryDevelopment;
use Exception;
use Illuminate\Http\{JsonResponse, Request};

class TemporaryDevelopmentsController extends Controller
{
    /**
     * TemporaryDevelopmentsController constructor.
     */
    public function __construct()
    {
        $this->middleware('verified');

        $this->middleware('can:update,temporary_development')->only(['update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'temporaryDevelopment' => $request->user()->temporaryDevelopment,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TemporaryDevelopmentRequest $request
     * @return JsonResponse
     */
    public function store(TemporaryDevelopmentRequest $request): JsonResponse
    {
        $request->user()->temporaryDevelopment()->create($request->all());

        return response()->json([
            'message' => trans('developments.temporary.store'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TemporaryDevelopmentRequest $request
     * @param TemporaryDevelopment        $temporaryDevelopment
     * @return JsonResponse
     */
    public function update(TemporaryDevelopmentRequest $request, TemporaryDevelopment $temporaryDevelopment): JsonResponse
    {
        $temporaryDevelopment->update($request->all());

        return response()->json([
            'message' => trans('developments.temporary.updated'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TemporaryDevelopment $temporaryDevelopment
     * @return void
     * @throws Exception
     */
    public function destroy(TemporaryDevelopment $temporaryDevelopment): void
    {
        $temporaryDevelopment->delete();
    }
}
