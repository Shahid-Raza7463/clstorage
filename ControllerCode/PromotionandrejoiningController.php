<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PromotionandrejoiningController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
}
