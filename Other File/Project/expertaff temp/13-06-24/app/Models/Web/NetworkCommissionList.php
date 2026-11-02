<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NetworkCommissionList extends Model
{
    use HasFactory;
    protected $table = "commission_types";
    protected $fillable = [
        'name'
    ];
}
