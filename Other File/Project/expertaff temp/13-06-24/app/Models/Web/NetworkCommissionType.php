<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NetworkCommissionType extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = "networks_commission_type";
    protected $fillable = [
        'network_id',
        'commission_type',
    ];
}
