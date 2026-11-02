<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NetworkSocialPage extends Model
{
    use HasFactory;
    protected $table = "network_social_pages";
    protected $fillable = [
        'network_id',
        'social_site',
        'social_link',
    ];
}
