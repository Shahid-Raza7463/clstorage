<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skills extends Model
{
    // use HasFactory;
    // protected $table = "skills";
    // protected $fillable = [
    //     'id',
    //     'name',
    //     'email',
    //     'skype',
    //     'subject',
    //     'message',
    // ];


    // Another way 
    use HasFactory;
    protected $guarded = [];
}
