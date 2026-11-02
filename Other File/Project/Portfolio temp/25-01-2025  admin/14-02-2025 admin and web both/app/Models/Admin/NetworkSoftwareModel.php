<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NetworkSoftwareModel extends Model
{
    use HasFactory;
    protected $table = "network_softwares";
    protected $fillable = [
        'id ',
        'name',
    ];
}
