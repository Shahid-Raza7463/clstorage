<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SkillsController extends Controller
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
