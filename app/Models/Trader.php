<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trader extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'picture_url',
        'picture_public_id',
        'is_verified',
        'verified_badge',
        'name',
        'min_portfolio',
        'experience',
        'percentage',
        'currency_pairs',
        'details',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_verified' => 'boolean',
        'min_portfolio' => 'decimal:2',
    ];
}
