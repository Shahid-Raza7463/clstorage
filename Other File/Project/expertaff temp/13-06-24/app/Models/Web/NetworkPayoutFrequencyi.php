<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NetworkPayoutFrequencyi extends Model
{
    use HasFactory;
    protected $table = "network_payout_frequency";
    protected $fillable = [
        'network_id',
        'payment_frequency',
    ];
}
