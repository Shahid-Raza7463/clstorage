<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;
    protected $table = "user_details";
    protected $fillable = [
        'user_id',
        'skype',
        'phone_number',
        'other_question',
    ];
}
