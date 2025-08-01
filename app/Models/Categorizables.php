<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorizables extends Model
{
    protected $fillable = [
        'category_id',
        'movieable_id',
        'movieable_type'
    ];
}
