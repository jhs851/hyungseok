<?php

namespace App\Http\Controllers\Api;

use App\Models\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;

class TagsController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index() : Collection
    {
        return Tag::orderBy('name', 'asc')->get();
    }
}
