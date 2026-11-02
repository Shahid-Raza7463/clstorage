<?php

namespace App\Http\Controllers\Admin;

use App\DB\NetworksDB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private NetworksDB $networkdb;
    function __construct()
    {
        $this->networkdb = new NetworksDB();
    }
    // Get all_sponsored_networks
    public function all_sponsored_networks()
    {
        $filters = ['is_sponsored' => 1];
        $sponsored_networks =  $this->networkdb->get_networks($filters);
        return $sponsored_networks;
    }

    // Get all_top_networks
    public function all_top_networks()
    {
        $filters = ['is_top_network' => 1];
        $top_networks =  $this->networkdb->get_networks($filters);
        return $top_networks;
    }
    // Get featured_networks
    public function featured_networks()
    {
        $filters = ['is_featured' => 1];
        $featured_networks =  $this->networkdb->get_networks($filters);
        return $featured_networks;
    }
    // Get latest_offers
    public function get_latest_offers()
    {
        $latest_offers =  $this->networkdb->get_offers();
        return $latest_offers;
    }
    // Get Top offers on offers page
    public function get_top_offers()
    {
        // Get Top offers on offers page
        $top_offers =  $this->networkdb->get_top_offers();
        return $top_offers;
    }
    // Get featured_offers
    public function get_featured_offers()
    {
        $filters = ['is_featured' => 1];
        $featured_offers =  $this->networkdb->get_offers($filters);
        return $featured_offers;
    }
    // Get all_adspaces
    public function get_all_adspaces()
    {
        // Get all_adspaces
        $ads =  $this->networkdb->get_all_adspaces();
        return $ads;
    }
    // Get network of the months ads image
    public function get_networkofthemonths_ads()
    {
        // Get network of the months ads image
        $ads =  $this->networkdb->get_networkofthemonths_ads();
        return $ads;
    }
    // Get home page carousel ads image
    public function home_page_carousel_ads()
    {
        $ads =  $this->networkdb->home_page_carousel_ads();
        return $ads;
    }
    // Get in page ads image
    public function in_page_ads()
    {
        $ads =  $this->networkdb->in_page_ads();
        return $ads;
    }
    // Get sponsored ads image
    public function sponsored_ads()
    {
        $ads =  $this->networkdb->sponsored_ads();
        return $ads;
    }
    // Get sponsored small ads image
    public function sponsored_small()
    {
        // Get sponsored small ads image
        $ads =  $this->networkdb->sponsored_small();
        return $ads;
    }
    // Get featured ads image
    public function featured_ads()
    {
        $ads =  $this->networkdb->featured_ads();
        return $ads;
    }
    // Get all_reviews
    public function get_all_reviews()
    {
        $all_reviews =  $this->networkdb->get_all_reviews();
        return $all_reviews;
    }
}
