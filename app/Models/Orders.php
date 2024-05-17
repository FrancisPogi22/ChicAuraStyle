<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'userID',
        'productID',
        'quantity',
        'totalPrice',
        'orderDate',
        'status'
    ];

    public $timestamps = false;
    
}
