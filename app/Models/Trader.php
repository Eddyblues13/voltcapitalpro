<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trader extends Model
{

    protected $fillable = [
        'picture',
        'is_verified',
        'verified_badge',
        'name',
        'return_rate',
        'min_amount',
        'max_amount',
        'followers',
        'profit_share',
    ];
}
