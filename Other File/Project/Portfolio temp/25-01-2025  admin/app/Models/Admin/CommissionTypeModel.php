<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionTypeModel extends Model
{
    use HasFactory;
    protected $table = "commission_types";
    protected $fillable = [
        'id ',
        'name',
    ];
}
