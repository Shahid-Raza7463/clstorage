<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Admin\AdspaceImages;
use Illuminate\Http\Request;
use App\Models\Admin\VerticalModel;
use App\Models\Admin\NetworkSoftwareModel;
use App\Models\Admin\OfferFetch;
use App\Models\Admin\PaymentFrequencyModel;
use App\Models\Admin\PaymentMethodModel;
use App\Models\Web\Offer;
use Illuminate\Support\Facades\DB;

class OffersWebController extends Controller
{
    public function index(Request $request, NetworkWebController $nwc)
    {

        // fetch all request from page
        $filters = $request->all();
        // Get ads image
        $adspace_image = $nwc->get_adspaces();
        // Get offers_adspaces on offers page
        $offers_adspaces = $nwc->get_offers_adspaces();
        $web_logo =  $nwc->get_settings();
        // Get seo_meta
        $seo_meta =  $nwc->get_seo_meta();
        // Get latest offers on offers page
        $latest_offers = $nwc->get_offers();
        // Get offers on offers page
        $offers = $nwc->get_offers();
        // Get top offers on offers page
        $top_offers = $nwc->get_top_offers();
        // Get_featured_offers
        $featured_offers = $nwc->get_featured_offers();
        // Get offers vertical
        $offers_verticals =  $nwc->get_offers_to_verticals();
        // dd($offers_verticals);

        // Get name of verticals in ascending order
        $network_categories = $nwc->get_verticals();
        // Get name of network_software_list in ascending order
        $software = $nwc->get_network_software_list();
        // Get name of network_frequency_list in ascending order
        $payment_frequency = $nwc->get_network_frequency_list();
        // Get name of payment method in ascending order
        $payment_method = $nwc->get_network_payment_list();
        // end hare,this is related for nav tab like network categories

        return view('web.pages.offers.offers', [
            'network_categories' => $network_categories,
            'software' => $software,
            'payment_frequency' => $payment_frequency,
            'payment_method' => $payment_method,
            'web_logo' => $web_logo,
            'adspace_image' => $adspace_image,
            'offers_adspaces' => $offers_adspaces,
            'offers' => $offers,
            'top_offers' => $top_offers,
            'latest_offers' => $latest_offers,
            'featured_offers' => $featured_offers,
            'offers_verticals' => $offers_verticals,
            'web_logo' => $web_logo,
            'seo_meta' => $seo_meta,
            'filters' => $filters
        ]);
    }
}
