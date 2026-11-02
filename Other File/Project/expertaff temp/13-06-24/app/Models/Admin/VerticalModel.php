<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerticalModel extends Model
{
    use HasFactory;
    protected $table = "verticals";
    protected $fillable = [
        'id',
        'title',
        'network_count',
        'icon',
        'status',
    ];
}
