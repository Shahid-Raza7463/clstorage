<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friendslistapi extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'color',
        'image',
    ];
}
