<?php
// app/Models/PaymentMethod.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'wallet_address',
        'coin_pic_path',
        'scan_code_path'
    ];

    // Validation rules
    public static $rules = [
        'name' => 'required|string|max:255',
        'wallet_address' => 'required|string|max:255',
        'coin_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'scan_code' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ];
}
