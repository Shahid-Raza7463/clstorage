<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NetworkSoftware extends Model
{
    use HasFactory;
    protected $table = "network_softwares";
    protected $fillable = [
        'name'
    ];
}
