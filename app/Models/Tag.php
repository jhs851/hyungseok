<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * 대량 할당 가능한 속성.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
}
