<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skills = DB::table('skills')->get();
        $socialmedia = DB::table('socialmedia')->get();
        $resume = DB::table('resume')->get();
        $projects_details = DB::table('projects_details')->get();
        $projects = DB::table('projects')->get();
        $contactus = DB::table('contactus')->get();
        $contactdetails = DB::table('contactdetails')->get();
        // dd($contactdetails, 111);
        return view('web.pages.home.index', compact('skills', 'socialmedia', 'resume', 'projects_details', 'projects', 'contactus', 'contactdetails'));
    }
}
