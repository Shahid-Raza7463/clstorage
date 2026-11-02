<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NetworkVertical extends Model
{
    use HasFactory;
    protected $table = "network_verticals";
    protected $fillable = [
        'network_id ',
        'vertical_id',
    ];
}
