<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;

    protected $fillable = [
        'Owner',
        'user_id',
        'name',
        'Active',
        'price',
        'category',
        'First_owner',
    ];
}
