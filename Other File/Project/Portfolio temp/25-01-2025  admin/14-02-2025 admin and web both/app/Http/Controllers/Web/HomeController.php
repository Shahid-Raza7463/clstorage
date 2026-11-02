<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
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
        $about = DB::table('about')
            ->leftjoin('teammembers', 'teammembers.id', 'about.teammember_id')
            ->select(
                'about.*',
                'teammembers.team_member',
                'teammembers.mobile_no',
                'teammembers.emailid',
                'teammembers.personalemail',
                'teammembers.dateofbirth',
                'teammembers.qualification',
                'teammembers.permanentaddress',
                'teammembers.communicationaddress',
            )
            ->first();
        // $dateofbirth = Carbon::parse($about->dateofbirth)->age;
        $skills = DB::table('skills')->where('status', 1)->get();
        $socialmedias = DB::table('socialmedia')->get();
        $homeimages = DB::table('homeimage')->first();
        $resumes = DB::table('resume')->first();
        $educations = DB::table('education')->get();
        $experiences = DB::table('professionalexperience')->get();
        $portfolios = DB::table('projects')->where('category_id', 1)->get();
        $applications = DB::table('projects')->where('category_id', 2)->get();
        // dd($homeimages);

        // $projects_details = DB::table('projects_details')->get();
        $contactus = DB::table('contactus')->get();
        $contactdetails = DB::table('contactdetails')->first();
        // dd($resume, 111);
        return view('web.pages.home.index', compact('skills', 'socialmedias', 'resumes', 'portfolios', 'contactus', 'contactdetails', 'applications', 'about', 'homeimages', 'educations', 'experiences'));
    }

    public function portfoliodetails($id)
    {

        $projectsdetails = DB::table('projects')
            ->where('id', $id)
            // ->where('id', 1)
            ->first();
        // dd($projectsdetails);

        $projectsimages = DB::table('projectimagefile')
            ->where('projects_id', $id)
            // ->where('projects_id', 1)
            ->get();

        $socialmedias = DB::table('socialmedia')->get();
        // dd($projectsdetails);
        return view('web.pages.portfolio.project8.portfolio', compact('projectsdetails', 'projectsimages', 'socialmedias'));
    }

    public function appdetails($id)
    {


        $projectsdetails = DB::table('projects')
            ->where('id', $id)
            // ->where('id', 2)
            ->first();
        // dd($projectsdetails);

        $projectsimages = DB::table('projectimagefile')
            ->where('projects_id', $id)
            // ->where('projects_id', 2)
            ->get();

        // dd($projectsdetails);
        $socialmedias = DB::table('socialmedia')->get();

        return view('web.pages.portfolio.androidapp4.androidapp', compact('projectsdetails', 'projectsimages', 'socialmedias'));
    }
}
