<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adspace extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'position',
        'image_url',
        'link',
        'status',
        'network_id',
        'expired_at',
        'add_user',
        'mod_user'
    ];
}
