<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferFetch extends Model
{
    use HasFactory;
    protected $table = "offers";
    protected $fillable = [
        'id',
        'icon',
        'title',
        'offer_id',
        'network_id',
        'payout',
        'countries',
        'status',
        'is_featured',
        'offer_image'
    ];
}
