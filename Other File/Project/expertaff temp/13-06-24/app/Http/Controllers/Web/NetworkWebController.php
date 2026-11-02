<?php

namespace App\Http\Controllers\Web;

use App\DB\NetworksDB;
// Get time formate like (posted 3 days ago )
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Admin\Adspace;
use App\Models\Admin\AdspaceImages;
use App\Models\Web\NetworkReviewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NetworkWebController extends Controller
{
    private NetworksDB $networkdb;
    function __construct()
    {
        $this->networkdb = new NetworksDB();
    }

    // get all data on network page
    public function index(Request $request, $network_slug = '', NetworkReviewsWebController $nrwcon)
    {
        // fetch all request from network page
        $filters = $request->all();
        // get particular networks data from networks table
        $network = $this->get_network($network_slug);
        // Get ads image
        $adspace_image = $this->get_adspaces();
        // website logo
        $web_logo =  $this->get_settings();
        // Get seo_meta
        $seo_meta =  $this->get_seo_meta();
        // get particular verticals on network page and offers page
        $network_verticals = $this->networkdb->get_network_to_verticals($network->network_id);
        // Get particular commission type
        $network_commission = $this->networkdb->get_network_to_commission_type($network->network_id);
        // Get particular payment method
        $network_payment = $this->networkdb->get_network_to_payment_method($network->network_id);
        // Get particular network frequency data
        $network_frequency = $this->networkdb->get_network_to_network_frequency($network->network_id);
        // Get particular contact email
        $contacts = $this->networkdb->get_contacts($network->user_id);
        // Get particular link of social name
        $sociallink = $this->networkdb->get_social_link($network->network_id);
        // Get offers on particular network page 
        $offers =  $this->get_network_offers($network->network_id);
        // Get network offers_verticals
        $offers_verticals =  $this->get_offers_to_verticals();
        // diagram rating 0n network page
        $presentation_rating =  $this->get_presentation_rating($network->network_id);
        //Get top network
        $top_networks =  $this->get_top_networks();
        //Get featured_networks
        $featured_networks =  $this->get_featured_networks();
        // get all reviews of one network on network page
        $network_review = $nrwcon->get_network_review($network->network_id);

        return view('web.pages.network.network', [
            'network' => $network,
            'network_verticals' => $network_verticals,
            'network_commission' => $network_commission,
            'network_payment' => $network_payment,
            'network_frequency' => $network_frequency,
            'top_networks' => $top_networks,
            'featured_networks' => $featured_networks,
            'contacts' => $contacts,
            'sociallink' => $sociallink,
            'network_review' => $network_review,
            'adspace_image' => $adspace_image,
            'offers' => $offers,
            'offers_verticals' => $offers_verticals,
            'web_logo' => $web_logo,
            'seo_meta' => $seo_meta,
            'filters' => $filters,
            'presentation_rating' => $presentation_rating,
            'network_slug' => $network_slug,
        ]);
    }
    // Get sponsored network
    public function get_sponsored_networks()
    {
        // Get number of limit
        //option_value is a column in system settings table
        $sponsoredCount =  $this->get_settings();
        $filters = ['is_sponsored' => 1, 'limit' => $sponsoredCount[2]['option_value']];
        // $filters = ['is_sponsored' => 1];
        $sponsored_networks =  $this->networkdb->get_networks($filters);
        return $sponsored_networks;
    }

    // Get top networks
    public function get_top_networks()
    {
        // Get number of limit
        $topNetworkCount =  $this->get_settings();
        $filters = ['is_top_network' => 1, 'limit' => $topNetworkCount[3]['option_value']];
        $top_networks = $this->networkdb->get_networks($filters);
        return $top_networks;
    }
    // Get Searching page to network
    public function get_search_networks($filters = [])
    {
        // pagination
        $filters['limit'] = isset($filters['limit']) ? $filters['limit'] : 5;
        $search_networks =  $this->networkdb->get_networks($filters, true);
        return $search_networks;
    }
    public function get_search_blogs($filters = [])
    {
        // pagination
        $filters['limit'] = isset($filters['limit']) ? $filters['limit'] : 5;
        $blogs_search =  $this->networkdb->get_blogs($filters, true);
        return $blogs_search;
    }
    //  get featured networks
    public function get_featured_networks()
    {
        // Get number of limit
        $featuredCount =  $this->get_settings();
        $filters = ['is_featured' => 1, 'limit' => $featuredCount[4]['option_value']];
        $featured_networks =  $this->networkdb->get_networks($filters);
        return $featured_networks;
    }
    // Get premium networks
    public function get_premium_networks($filters = [])
    {
        // pagination
        $filters['limit'] = isset($filters['limit']) ? $filters['limit'] : 7;
        $premium_networks =  $this->networkdb->get_networks($filters, true);
        return $premium_networks;
    }

    // get particular networks data from networks table
    public function get_network($network_slug = '')
    {
        $filter = [
            'network_slug' => $network_slug
        ];
        return $this->networkdb->get_network($filter);
    }

    // get particular verticals on network page and offers page
    public function get_network_to_verticals()
    {
        $network_verticals =  $this->networkdb->get_network_to_verticals();
        return $network_verticals;
    }

    // Get particular commission type
    public function get_network_to_commission_type()
    {
        $network_commission =  $this->networkdb->get_network_to_commission_type();
        return $network_commission;
    }
    // Get particular payment method
    public function get_network_to_payment_method()
    {
        $network_payment =  $this->networkdb->get_network_to_payment_method();
        return $network_payment;
    }

    // Get particular network frequency data
    public function get_network_to_network_frequency()
    {
        $network_frequency =  $this->networkdb->get_network_to_network_frequency();
        return $network_frequency;
    }
    // Get particular contact email
    public function get_contacts()
    {
        $contacts =  $this->networkdb->get_contacts();
        return $contacts;
    }

    // Get name of verticals in ascending order
    public function get_verticals()
    {
        return $this->networkdb->get_verticals();
    }
    // get name of network_software_list in ascending order
    public function get_network_software_list()
    {
        return $this->networkdb->get_network_software_list();
    }
    // Get name of network_frequency_list in ascending order
    public function get_network_frequency_list()
    {
        return $this->networkdb->get_network_frequency_list();
    }
    // Get name of payment method in ascending order
    public function get_network_payment_list()
    {
        return $this->networkdb->get_network_payment_list();
    }
    // Get ads image
    public function get_adspaces()
    {
        return $this->networkdb->get_adspaces();
    }
    // Get offers_adspaces on offers page
    public function get_offers_adspaces()
    {
        return $this->networkdb->get_offers_adspaces();
    }
    // Get reviews_adspaces on reviews page
    public function get_reviews_adspaces()
    {
        return $this->networkdb->get_reviews_adspaces();
    }
    // website logo
    public function get_settings()
    {
        return $this->networkdb->get_settings();
    }
    // Get seo_meta
    public function get_seo_meta()
    {
        return $this->networkdb->get_seo_meta();
    }
    // Get blogsViews page of blogs
    public function get_blogsview($slug = '')
    {
        $filter = [
            'slug' => $slug
        ];
        return $this->networkdb->get_blogsview($filter);
    }
    // Get blogs on blogs page
    public function get_blogs($filters = [])
    {
        $filters = ['limit' => 4];
        $blogs = $this->networkdb->get_blogs($filters, true);
        return $blogs;
    }
    // Get offers on offers page
    public function get_offers()
    {
        $filters = ['limit' => 40];
        $offers = $this->networkdb->get_offers($filters);
        return $offers;
    }
    // Get offers on particular network page 
    public function get_network_offers($network_id)
    {
        $offers =  $this->networkdb->get_network_offers(['network_id' => $network_id]);
        return $offers;
    }
    // Get top offers on offers page
    public function get_top_offers()
    {
        // Get Top offers on offers page
        $top_offers = $this->networkdb->get_top_offers();
        return $top_offers;
    }
    // Get_featured_offers
    public function get_featured_offers()
    {

        // $limitCount = 5;
        // $filters = ['is_featured' => 1, 'limit' => $limitCount];
        $filters = ['is_featured' => 1];
        $offers = $this->networkdb->get_offers($filters);
        return $offers;
    }
    // Get offers vertical
    public function get_offers_to_verticals()
    {
        $offers_verticals =  $this->networkdb->get_offers_to_verticals();
        return $offers_verticals;
    }
    // diagram rating 0n network page
    public function get_presentation_rating($network_id)
    {
        $result = $this->networkdb->get_presentation_rating($network_id);
        return $result;
    }
}
