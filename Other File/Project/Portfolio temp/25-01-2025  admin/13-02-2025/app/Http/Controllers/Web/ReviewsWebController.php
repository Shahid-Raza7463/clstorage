<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Admin\AdspaceImages;
use Illuminate\Http\Request;

class ReviewsWebController extends Controller
{

    public function index(Request $request, NetworkWebController $nwc, NetworkReviewsWebController $nrwc)
    {

        // fetch all request from networks page when user click
        $filters = $request->all();
        // get ad image 
        $adspace_image = $nwc->get_adspaces();
        // Get reviews_adspaces on reviews page
        $reviews_adspaces = $nwc->get_reviews_adspaces();
        // get web logo 
        $web_logo =  $nwc->get_settings();
        // Get seo_meta
        $seo_meta =  $nwc->get_seo_meta();
        // get reviews of all networks on review page

        $networks_review = $nrwc->get_reviews($filters);
        // Get top networks
        $top_networks =  $nwc->get_top_networks();
        //  get featured networks
        $featured_networks =  $nwc->get_featured_networks();


        return view('web.pages.reviews.reviews', [
            'networks_review' => $networks_review,
            'top_networks' => $top_networks,
            'featured_networks' => $featured_networks,
            'adspace_image' => $adspace_image,
            'reviews_adspaces' => $reviews_adspaces,
            'web_logo' => $web_logo,
            'seo_meta' => $seo_meta,
            'filters' => $filters,
        ]);
    }
}
