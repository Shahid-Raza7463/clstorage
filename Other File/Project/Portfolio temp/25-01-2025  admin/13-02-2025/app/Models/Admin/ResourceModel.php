<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceModel extends Model
{
    use HasFactory;
    protected $table = "resources";
    protected $fillable = [
        'id',
        'categories_title',
        'parent_id',
        'link',
        'status',
        'description'
    ];
}
