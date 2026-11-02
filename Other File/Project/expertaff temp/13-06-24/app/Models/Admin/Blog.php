<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'title',
        'description',
        'preview_image',
        'category',
        'network_id',
        'add_user',
        'update_user',
        'status',
        'sponsored',
        'featured',
        'meta_title',
        'meta_description',
        'tags',
        'slug'
    ];
}
