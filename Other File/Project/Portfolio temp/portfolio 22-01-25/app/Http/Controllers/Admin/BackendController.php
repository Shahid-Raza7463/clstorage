<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BackendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skills = DB::table('skills')->get();
        dd($skills);
        return view('backEnd.promotion.index', compact('skills'));
    }
}
