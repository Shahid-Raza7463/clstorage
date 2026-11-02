<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NetworksWebModel extends Model
{
    use HasFactory;
    protected $table = "networks";
    protected $primaryKey = 'network_id';
    // public $incrementing = false;
    protected $fillable = [
        'network_id',
        'network_name',
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
        'is_sponsored ',
        'status',
    ];
    // one to many relationship on network payment method
    public function getnetwork_payment()
    {
        return $this->hasMany('App\Models\Web\NetworkSocialPage', 'network_id');

        // return $this->hasOne('App\Models\Web\NetworkSocialPage', 'network_id');
    }
}
