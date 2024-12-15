<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'customer_name',
        'customer_email',
        'product_name',
        'amount',
        'currency',
        'payment_status',
    ];
}
