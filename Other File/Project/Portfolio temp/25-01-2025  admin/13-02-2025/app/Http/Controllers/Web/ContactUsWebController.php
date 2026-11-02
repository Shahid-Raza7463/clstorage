<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Web\ContactUs;
use App\Models\Web\ContacUs;
use Dotenv\Validator;
use Illuminate\Http\Request;

class ContactUsWebController extends Controller
{
    // Get contactus page
    public function index(NetworkWebController $nwc)
    {
        // Get web logo 
        $web_logo =  $nwc->get_settings();
        // Get seo_meta
        $seo_meta =  $nwc->get_seo_meta();
        // Get ad image 
        $adspace_image = $nwc->get_adspaces();
        return view('web.pages.contactus.contactus', [
            'adspace_image' => $adspace_image,
            'web_logo' => $web_logo,
            'seo_meta' => $seo_meta,
        ]);
    }
    // store data from contact us form
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' =>  "required|string",
            'email' =>  "required|email",
            'subject' =>  "required",
            'message' =>  "required"
        ]);

        $contact  = $request->all();
        ContactUs::create($contact);
        return [
            'success' => true
        ];
    }
}
