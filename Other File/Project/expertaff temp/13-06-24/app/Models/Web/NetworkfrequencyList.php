<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NetworkfrequencyList extends Model
{
    use HasFactory;
    protected $table = "net_frequency_lists";
    protected $fillable = [
        'name'
    ];
}
