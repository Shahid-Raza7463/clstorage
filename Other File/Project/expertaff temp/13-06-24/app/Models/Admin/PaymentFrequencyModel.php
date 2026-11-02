<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentFrequencyModel extends Model
{
    use HasFactory;
    protected $table = "net_frequency_lists";
    protected $fillable = [
        'id ',
        'name',
    ];
}
