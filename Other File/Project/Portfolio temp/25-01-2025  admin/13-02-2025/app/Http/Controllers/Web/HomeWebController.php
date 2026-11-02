<?php

namespace App\Http\Controllers\Web;

use Illuminate\Support\Facades\Cache;
use App\DB\NetworksDB;
use App\Http\Controllers\Controller;
use App\Models\Admin\AdspaceImages;
use App\Models\Web\Network;
use App\Models\Admin\Vertical;
use App\Models\Admin\NetworkSoftwareModel;
use App\Models\Admin\PaymentFrequencyModel;
use App\Models\Admin\PaymentMethodModel;
use App\Models\Admin\SystemSettingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function GuzzleHttp\Promise\is_settled;

class HomeWebController extends Controller
{
    // Get Home page
    public function index(Request $request, NetworkWebController $nwc)
    {
        // fetch all request from Home page
        $filters = $request->all();

        // display latest and most reviews using toggle button
        $order_by = 'latest';
        // pagination
        $filters = empty($filters) ? [] : $filters;

        if (isset($filters['order_by'])) {
            $order_by = $filters['order_by'];
        } else {
            $filters['order_by'] = $order_by;
        }

        // Get ads image
        $adspace_image = Cache::remember('adspace_image', 120, function () use ($nwc) {
            return $nwc->get_adspaces();
        });
        // Get sponsored network
        $sponsored_networks = Cache::remember('sponsored_networks', now()->addHours(2), function () use ($nwc) {
            return $nwc->get_sponsored_networks();
        });
        // website logo
        $web_logo = Cache::remember('web_logo', now()->addHours(2), function () use ($nwc) {
            return $nwc->get_settings();
        });
        // seo_meta
        $seo_meta = Cache::remember('seo_meta', now()->addHours(2), function () use ($nwc) {
            return $nwc->get_seo_meta();
        });
        // Get premium_networks
        $premium_networks =  $nwc->get_premium_networks($filters);

        // side component
        // Get top networks
        $top_networks = Cache::remember('top_networks', now()->addHours(2), function () use ($nwc) {
            return $nwc->get_top_networks();
        });
        //Get featured_networks
        $featured_networks = Cache::remember('featured_networks', now()->addHours(2), function () use ($nwc) {
            return $nwc->get_featured_networks();
        });

        // Get name of verticals in ascending order
        $network_categories = Cache::remember('network_categories', now()->addHours(2), function () use ($nwc) {
            return $nwc->get_verticals();
        });
        // Get name of network_software_list in ascending order
        $software = Cache::remember('software', now()->addHours(2), function () use ($nwc) {
            return $nwc->get_network_software_list();
        });
        // Get name of network_frequency in ascending order
        $payment_frequency = Cache::remember('payment_frequency', now()->addHours(2), function () use ($nwc) {
            return $nwc->get_network_frequency_list();
        });
        // Get name of payment method in ascending order
        $payment_method = Cache::remember('payment_method', now()->addHours(2), function () use ($nwc) {
            return $nwc->get_network_payment_list();
        });


        // send all data on home.blade.php file
        return view('web.pages.home.home', [
            'sponsored_networks' => $sponsored_networks,
            'premium_networks' => $premium_networks,
            //get filter after click 2,3 page number so use appends method
            'premium_networks' => $premium_networks->appends($filters),
            'top_networks' => $top_networks,
            'featured_networks' => $featured_networks,
            'software' => $software,
            'payment_method' => $payment_method,
            'payment_frequency' => $payment_frequency,
            'network_categories' => $network_categories,
            'order_by' => $order_by,
            'filters' => $filters,
            'adspace_image' => $adspace_image,
            'web_logo' => $web_logo,
            'seo_meta' => $seo_meta,
        ]);
    }
}
