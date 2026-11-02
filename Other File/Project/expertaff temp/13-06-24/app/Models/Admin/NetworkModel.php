<?php
// for admin pannel
namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NetworkModel extends Model
{
    use HasFactory;
    protected $table = "networks";
    protected $fillable = [
        'network_id',
        'network_name ',
        'network_type',
        'network_url',
        'network_description',
        'offer_count',
        'min_payout',
        'referral_commission',
        'affiliate_tracking_software ',
        'other_optional_questions',
        'logo',
        'user_id',
        'review_count',
        'rating',
        'tracking_link',
        'is_sponsored',
        'network_slug',
        'status',
        'is_sponsored',
        'is_top_network',
        'is_featured',
    ];
}
