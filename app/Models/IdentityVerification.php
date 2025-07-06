<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdentityVerification extends Model
{

    protected $fillable = [
        'user_id',
        'front_photo_path',
        'back_photo_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
