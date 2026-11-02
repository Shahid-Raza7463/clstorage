<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSettingModel extends Model
{
    use HasFactory;
    protected $table = "system_settings";
    protected $fillable = [
        'id',
        'option_name',
        'option_value',
        'header_js',
        'footer_js',
        'auto_load'
    ];
}
