<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NetworkPaymentList extends Model
{
    use HasFactory;
    protected $table = "payment_lists";
    protected $fillable = [
        'name'
    ];
}
