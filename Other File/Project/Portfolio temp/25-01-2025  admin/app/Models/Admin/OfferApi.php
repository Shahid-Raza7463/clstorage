<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferApi extends Model
{
    use HasFactory;
    protected $table = 'offers_api';
    protected $fillable = [
        'id',
        'api_url',
        'network_id',
        'status',
        'tracking_software',
        'frequency'
    ];
}
