<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    use HasFactory;
    protected $table = "networks";
    protected $primaryKey = 'network_id';
    // public $incrementing = false;
    protected $fillable = [
        'network_id',
        'network_name',
        'network_slug',
        'network_type',
        'network_url',
        'network_description',
        'affiliate_tracking_software',
        'offer_count',
        'min_payout',
        'payout_frequency',
        'referral_commission',
        'user_id',
        'logo',
        'review_count',
        'rating',
        'is_sponsored',
        'support_ratings',
        'tracking_ratings',
        'payout_ratings',
        'offer_ratings',
        'status',
    ];
}
