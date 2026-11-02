<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Admin\AdspaceImages;
use App\Models\Admin\Blog;
use Illuminate\Http\Request;

class BlogsWebController extends Controller
{
    // Get blogs page
    public function index(Request $request, NetworkWebController $nwc)
    {
        // fetch all request from blogs page
        $filters = $request->all();

        // Get blogs on blogs page
        $blogs =  $nwc->get_blogs();
        // dd($blogs);
        // get web logo 
        $web_logo =  $nwc->get_settings();
        // Get seo_meta
        $seo_meta =  $nwc->get_seo_meta();
        // Get ads image
        $adspace_image = $nwc->get_adspaces();
        // Get top networks
        $top_networks =  $nwc->get_top_networks();
        //  get featured networks
        $featured_networks =  $nwc->get_featured_networks();

        return view('web.pages.blogs.blogs', [
            'top_networks' => $top_networks,
            'featured_networks' => $featured_networks,
            'adspace_image' => $adspace_image,
            'web_logo' => $web_logo,
            'seo_meta' => $seo_meta,
            'blogs' => $blogs,
            'filters' => $filters,
        ]);
    }
}
