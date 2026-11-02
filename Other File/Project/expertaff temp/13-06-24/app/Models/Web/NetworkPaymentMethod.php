<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NetworkPaymentMethod extends Model
{
    use HasFactory;
    protected $table = "network_payment_method";
    protected $fillable = [
        'network_id',
        'payment_method',
    ];
}
