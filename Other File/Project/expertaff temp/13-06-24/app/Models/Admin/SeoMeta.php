<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoMeta extends Model
{
    use HasFactory;
    protected $table = "seo_meta";
    protected $fillable = [
        'id',
        'name',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];
}
