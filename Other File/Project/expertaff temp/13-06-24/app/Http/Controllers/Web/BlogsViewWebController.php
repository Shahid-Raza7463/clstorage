<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Admin\Blog;
use Illuminate\Http\Request;

class BlogsViewWebController extends Controller
{
    // Get blogs views page
    public function index(Request $request, $slug = '', NetworkWebController $nwc)
    {
        // fetch all request from blogs page
        $filters = $request->all();
        // Get two blogs on blogsview page
        $blogs =  $nwc->get_blogs();
        // Get blogsViews page of blogs
        $blogsview = $nwc->get_blogsview($slug);
        // Get web logo 
        $web_logo =  $nwc->get_settings();
        // Get seo_meta
        $seo_meta =  $nwc->get_seo_meta();
        // Get ads image
        $adspace_image = $nwc->get_adspaces();
        // Get top networks
        $top_networks =  $nwc->get_top_networks();
        //  get featured networks
        $featured_networks =  $nwc->get_featured_networks();

        return view('web.pages.blogsview.blogsview', [
            'top_networks' => $top_networks,
            'featured_networks' => $featured_networks,
            'adspace_image' => $adspace_image,
            'web_logo' => $web_logo,
            'seo_meta' => $seo_meta,
            'blogsview' => $blogsview,
            'blogs' => $blogs,
            'filters' => $filters,
            'slug' => $slug
        ]);
    }
}
