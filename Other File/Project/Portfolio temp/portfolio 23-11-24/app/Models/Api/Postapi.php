<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postapi extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
    ];
}
