<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialSiteListList extends Model
{
    use HasFactory;
    protected $table = "social_site_list";
    protected $fillable = [
        'name'
    ];
}
