<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Admin\AdspaceImages;
use Illuminate\Http\Request;

class SearchWebController extends Controller
{
    public function index(Request $request, NetworkWebController $nwc, NetworkReviewsWebController $nrwc)
    {
        // fetch all request from page
        $filters = $request->all();
        // dd($filters);
        // Get ads image
        $adspace_image = $nwc->get_adspaces();
        // Get web logo
        $web_logo =  $nwc->get_settings();
        // Get seo_meta
        $seo_meta =  $nwc->get_seo_meta();
        //* filter for searching
        // Get Searching page to network
        $search_networks =  $nwc->get_search_networks($filters);
        // Get searching reviews functionality
        $networks_review =  $nrwc->get_search_reviews($filters);
        // get blogs searching functionality
        $blogs_search =  $nwc->get_search_blogs($filters);
        // dd($blogs_search);
        //* filter for searching end
        // Get top networks
        $top_networks =  $nwc->get_top_networks();
        //  get featured networks
        $featured_networks =  $nwc->get_featured_networks();

        // Get name of verticals in ascending order
        $network_categories = $nwc->get_verticals();
        // Get name of network_software_list in ascending order
        $software = $nwc->get_network_software_list();
        // Get name of network_frequency_list in ascending order
        $payment_frequency = $nwc->get_network_frequency_list();
        // Get name of payment method in ascending order
        $payment_method = $nwc->get_network_payment_list();


        return view('web.pages.search.search_index', [

            // get filter when click on next page so used appends($filters)
            'networks' => $search_networks->appends($filters),
            'top_networks' => $top_networks,
            'featured_networks' => $featured_networks,
            'software' => $software,
            'payment_method' => $payment_method,
            'payment_frequency' => $payment_frequency,
            'network_categories' => $network_categories,
            'filters' => $filters,
            'blogs_search' => $blogs_search,
            'networks_review' => $networks_review,
            'adspace_image' => $adspace_image,
            'web_logo' => $web_logo,
            'seo_meta' => $seo_meta,
            // set old value in search input box
            'search' => isset($filters['search']) ? $filters['search'] : '',
        ]);
    }
}
