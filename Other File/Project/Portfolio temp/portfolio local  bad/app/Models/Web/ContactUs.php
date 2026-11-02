<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;
    protected $table = "contactus";
    protected $fillable = [
        'id',
        'name',
        'email',
        'skype',
        'subject',
        'message',
    ];
}
