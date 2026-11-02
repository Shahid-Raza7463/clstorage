<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projectimagefile extends Model
{
    // use HasFactory;
    // protected $fillable = [
    //     'id',
    //     'title',
    //     'description',
    //     'preview_image',
    //     'category',
    //     'network_id',
    //     'add_user',
    //     'update_user',
    //     'status',
    //     'sponsored',
    //     'featured',
    //     'meta_title',
    //     'meta_description',
    //     'tags',
    //     'slug'
    // ];

    // "id" => 1
    // "projects_id" => 1
    // "image" => "img/portfolio/project-vsaedit.png"
    // "created_at" => null
    // "updated_at" => null

    // Another way 
    use HasFactory;
    protected $table = "projectimagefile";
    protected $guarded = [];
}
