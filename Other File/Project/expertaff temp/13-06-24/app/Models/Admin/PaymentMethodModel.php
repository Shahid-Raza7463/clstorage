<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethodModel extends Model
{
    use HasFactory;
    protected $table = "payment_lists";
    protected $fillable = [
        'id ',
        'name',
    ];
}
