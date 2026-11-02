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

        // $skills = DB::table('skills')
        //     ->update([
        //         'status' => 1,
        //     ]);



        // $htmlContent = '
        // <ul>
        //     <li>Programming Languages, Tools & Technologies, and Frameworks & Libraries: PHP, Laravel, MySQL, AJAX, JSON, JavaScript, React.js, Node.js, React Native, HTML, CSS, jQuery, Bootstrap, Git, and C Programming.</li>
        // </ul>';

        // // Insert into the database
        // DB::table('resume')
        //     ->where('id', 1)
        //     ->update([
        //         'technicalskills' => $htmlContent,
        //     ]);






        // dd('hi');
        $skills = DB::table('skills')->first();
        $socialmedia = DB::table('socialmedia')->first();
        $resume = DB::table('resume')->first();
        $projects_details = DB::table('projects_details')->get();
        $portfolio = DB::table('projects')->first();
        $application = DB::table('projects')->first();
        $contactus = DB::table('contactus')->get();
        $contactdetails = DB::table('contactdetails')->first();
        // dd($resume, 111);
        return view('web.pages.home.index', compact('skills', 'socialmedia', 'resume', 'projects_details', 'portfolio', 'contactus', 'contactdetails', 'application'));
    }
}
