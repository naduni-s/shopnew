<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefillRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name', 'address', 'phone_number', 'decant_name', 'price', 'size', 'status',
    ];
}
