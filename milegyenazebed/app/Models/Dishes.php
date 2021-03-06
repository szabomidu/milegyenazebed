<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dishes extends Model
{
    use HasFactory;

    protected $fillable = [
        'dish_name',
        'is_new',
        'menu_id',
        'updated_at',
        'created_at'
    ];
}
