<?php

namespace App\DB;

use App\Models\Admin\AddJs;
use App\Models\Admin\Adspace;
use App\Models\Admin\AdspaceImages;
use App\Models\Admin\NetworkSoftwareModel;
use App\Models\Admin\PaymentFrequencyModel;
use App\Models\Admin\PaymentMethodModel;
use App\Models\Admin\SeoMeta;
use App\Models\Admin\SystemSettingModel;
use App\Models\Admin\VerticalModel;
use App\Models\Web\Network;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class NetworksDB
{
    // get data for all networks
    public function get_networks($filters = [], $paginate = false)
    {
        // select column name 
        $select = [];
        $select[] = "n.network_id";
        $select[] = "n.network_name";
        $select[] = "n.network_type";
        $select[] = "n.network_url";
        $select[] = "n.network_description";
        $select[] = "n.offer_count";
        $select[] = "n.min_payout";
        $select[] = "n.referral_commission";
        $select[] = "n.affiliate_tracking_software";
        $select[] = "n.logo";
        $select[] = "n.review_count";
        $select[] = "n.rating";
        $select[] = "n.tracking_link";
        $select[] = "n.is_sponsored";
        $select[] = "n.is_top_network";
        $select[] = "n.is_featured";
        $select[] = "n.network_slug";
        $select[] = "n.status";
        // $select[] = "n.created_at";
        $select[] = "nr.all_rating";
        $select[] = "nr.offer_rating";
        $select[] = "nr.payout_rating";
        $select[] = "nr.tracking_rating";
        $select[] = "nr.support_rating";
        $select[] = "nr.review_text";
        $select[] = "nr.review_img";
        $select[] = "nr.review_id";
        $select[] = "nr.created_at";
        //group concat for vertical icon
        $select[] = DB::raw("GROUP_CONCAT(DISTINCT CONCAT(v.title,':',v.icon) ) as verticals_titles");
        //group concat for network frequency list
        $select[] = DB::raw("GROUP_CONCAT(DISTINCT nfl.name ) as name");
        //group concat for network payment list
        $select[] = DB::raw("GROUP_CONCAT(DISTINCT pl.name ) as payment_lists");
        //group concat for network commission type 
        $select[] = DB::raw("GROUP_CONCAT(DISTINCT ct.name ) as commission_type");

        // joining table
        $query = DB::table('networks AS n')->select($select)

            ->leftJoin('network_review AS nr', 'nr.network_id', '=', 'n.network_id')

            ->leftJoin('network_verticals AS nv', 'n.network_id', '=', 'nv.network_id')
            ->leftJoin('verticals AS v', 'nv.vertical_id', '=', 'v.id')

            ->leftJoin('network_payout_frequency AS npf', 'n.network_id', '=', 'npf.network_id')
            ->leftJoin('net_frequency_lists AS nfl', 'npf.payment_frequency', '=', 'nfl.id')

            ->leftJoin('network_payment_method AS npm', 'n.network_id', '=', 'npm.network_id')
            ->leftJoin('payment_lists AS pl', 'npm.payment_method', '=', 'pl.id')

            ->leftJoin('networks_commission_type AS nct', 'n.network_id', '=', 'nct.network_id')
            ->leftJoin('commission_types AS ct', 'nct.commission_type', '=', 'ct.id')

            ->groupBy('n.network_id');
        // dd($query);


        // filter applied

        // get only sponsored network on home page
        if (isset($filters['is_sponsored']) && $filters['is_sponsored'] == 1) {
            $query->where('n.is_sponsored', 1);
        }
        // get only top network on home page
        if (isset($filters['is_top_network']) && $filters['is_top_network'] == 1) {
            $query->where('n.is_top_network', 1);
        }
        // get only featured network on home page
        if (isset($filters['is_featured']) && $filters['is_featured'] == 1) {
            $query->where('n.is_featured', 1);
        }
        //get latest and most review network on home premium section
        if (isset($filters['order_by']) && $filters['order_by'] == 'latest') {
            $query->orderBy('n.created_at', 'DESC');
        }
        if (isset($filters['order_by']) && $filters['order_by'] == 'reviews') {
            $query->orderBy('n.review_count', 'DESC');
        }

        //filters on nav tab like networks categories,tracking software, etc
        if (isset($filters['software']) && $filters['software'] != '') {
            $query->where('n.affiliate_tracking_software', $filters['software']);
        }

        if (isset($filters['vertical']) && $filters['vertical'] != '') {
            $query->where('v.title', $filters['vertical']);
        }

        if (isset($filters['payment_frequency']) && $filters['payment_frequency'] != '') {
            $query->where('nfl.name', $filters['payment_frequency']);
        }
        if (isset($filters['payment_method']) && $filters['payment_method'] != '') {
            $query->where('pl.name', $filters['payment_method']);
        }

        // get get_search_networks
        if (isset($filters['search']) && $filters['search'] != '') {
            $query->where('network_name', 'LIKE', "%" . $filters['search'] . "%");
        }
        //pagination
        if (isset($filters['limit']) && $filters['limit'] > 0) {
            return $query->paginate($filters['limit']);
        } else {
            return $query->get();
            // return $query->paginate(15);
        }
    }

    ###########################################
    // Network Page
    ############################################

    // get particular networks data from networks table
    public function get_network($filters = [])
    {

        $select = [];
        $select[] = "*";
        return DB::table('networks AS n')->select($select)
            ->where('network_slug', $filters['network_slug'])
            ->first();
    }

    // get particular verticals on network page and offers page
    public function get_network_to_verticals($network_id = 0)
    {
        return DB::table('verticals AS v')
            ->leftJoin('network_verticals AS nv', "nv.vertical_id", "=", "v.id")
            ->where('nv.network_id', $network_id)
            ->orderBy('title', 'asc')->get(['icon', 'title'])->toArray();
    }

    // Get particular commission type
    public function get_network_to_commission_type($network_id = 0)
    {
        return DB::table('commission_types AS ct')
            ->leftJoin('networks_commission_type AS nct', "nct.commission_type", "=", "ct.id")
            ->where('nct.network_id', $network_id)
            ->orderBy('name', 'asc')->get(['name'])->toArray();
    }

    // Get particular payment method
    public function get_network_to_payment_method($network_id = 0)
    {
        return DB::table('payment_lists AS pl')
            ->leftJoin('network_payment_method AS npm', "npm.payment_method", "=", "pl.id")
            ->where('npm.network_id', $network_id)
            ->orderBy('name', 'asc')->get(['name'])->toArray();
    }
    // Get particular network frequency data
    public function get_network_to_network_frequency($network_id = 0)
    {
        return DB::table('net_frequency_lists AS nfl')
            ->leftJoin('network_payout_frequency AS npf', "npf.payment_frequency", "=", "nfl.id")
            ->where('npf.network_id', $network_id)
            ->orderBy('name', 'asc')->get(['name'])->toArray();
    }
    // Get particular contact email
    public function get_contacts($user_id = 0)
    {
        return DB::table('users AS u')
            ->leftJoin('user_details AS ud', "ud.user_id", "=", "u.id")
            ->where('u.id', $user_id)->get(['email'])->toArray();
    }
    // Get particular link of social name
    public function get_social_link($network_id = 0)
    {
        return DB::table('networks AS n')
            ->leftJoin('network_social_pages AS nsp', "nsp.network_id", "=", "n.network_id")
            ->where('n.network_id', $network_id)
            ->orderBy('social_link', 'asc')->get(['social_link'])->toArray();
    }

    // diagram rating 0n network page
    public function get_presentation_rating($network_id)
    {
        $select[] = DB::raw("SUM(CASE
         WHEN nr.all_rating = 5 THEN 1
         ELSE 0
     END) AS excellent");
        $select[] = DB::raw("SUM(CASE
         WHEN nr.all_rating >= 4 AND nr.all_rating < 5 THEN 1
         ELSE 0
     END) AS very_good");
        $select[] = DB::raw("SUM(CASE
     WHEN nr.all_rating >= 3 AND nr.all_rating < 4 THEN 1
     ELSE 0
 END) AS average");
        $select[] = DB::raw("SUM(CASE
         WHEN nr.all_rating >= 2 AND nr.all_rating < 3 THEN 1
         ELSE 0
     END) AS poor");
        $select[] = DB::raw("SUM(CASE
         WHEN nr.all_rating >= 1 AND nr.all_rating < 2 THEN 1
         ELSE 0
     END) AS triable");

        // $result = DB::table('network_review AS nr')
        //     ->select($select)
        //     ->first();


        $result = DB::table('network_review AS nr')
            ->select($select)
            ->where('network_id', $network_id)
            ->first();


        // Calculate percentages
        $totalCount = $result->excellent + $result->very_good + $result->average + $result->poor + $result->triable;
        // dd($totalCount);
        if ($totalCount != 0) {
            $percentageData = [
                'excellent' => round(($result->excellent / $totalCount) * 100, 1),
                'very_good' => round(($result->very_good / $totalCount) * 100, 1),
                'average' => round(($result->average / $totalCount) * 100, 1),
                'poor' => round(($result->poor / $totalCount) * 100, 1),
                'triable' => round(($result->triable / $totalCount) * 100, 2),
            ];
        } else {
            $percentageData = [
                'excellent' => 0,
                'very_good' => 0,
                'average' => 0,
                'poor' => 0,
                'triable' => 0,
            ];
        }

        return $percentageData;
    }

    // Get offers on particular network page 
    public function get_network_offers($filters = [])
    {
        $select = [];
        $select[] = "o.id";
        $select[] = "o.icon";
        $select[] = "o.title";
        $select[] = "o.offer_id";
        $select[] = "o.network_id";
        $select[] = "o.payout";
        $select[] = "o.countries";
        $select[] = "o.status";
        $select[] = "o.currency";
        $select[] = "o.category";
        $select[] = "o.offer_image";
        $select[] = "o.is_featured";
        $select[] = "o.created_at";
        $select[] = "o.updated_at";
        $select[] = "n.network_name";

        // joining table
        $query = DB::table('offers AS o')->select($select)
            ->leftJoin('networks AS n', 'n.network_id', '=', 'o.network_id')
            ->orderBy('o.created_at', 'desc');

        if (isset($filters['network_id']) && $filters['network_id'] > 0) {
            $query->where('o.network_id', $filters['network_id']);
        }

        //pagination
        if (isset($filters['limit']) && $filters['limit'] > 0) {
            return $query->paginate($filters['limit']);
        } else {

            return $query->paginate(10);
        }
    }

    ###########################################
    //home page
    ############################################
    // Get name of verticals in ascending order
    public function get_verticals()
    {
        $select = [];
        $select[] = "v.title";
        $select[] = "v.icon";
        $select[] = DB::raw("COUNT(nv.network_id) as network_numbers");
        $titles = DB::table('verticals AS v')->select($select)
            ->leftJoin('network_verticals AS nv', "nv.vertical_id", "=", "v.id")->where('status', 1)
            ->groupBy("v.id")->orderBy('title', 'asc')->get()->toArray();
        return $titles;
    }

    // get name of network_software_list in ascending order
    public function get_network_software_list()
    {
        $select = [];
        $select[] = "ns.name";
        $select[] = DB::raw("COUNT(n.network_id) as network_numbers");
        $titles = DB::table('network_softwares AS ns')->select($select)
            ->leftJoin('networks AS n', "n.affiliate_tracking_software", "=", "ns.name")
            ->groupBy("ns.name")->orderBy('name', 'asc')->get()->toArray();
        return $titles;
    }

    // Get name of network_frequency_list in ascending order
    public function get_network_frequency_list()
    {
        $select = [];
        $select[] = "nfl.name";
        $select[] = DB::raw("COUNT(npf.network_id) as network_numbers");
        $titles = DB::table('net_frequency_lists AS nfl')->select($select)
            ->leftJoin('network_payout_frequency AS npf', "npf.payment_frequency", "=", "nfl.id")
            ->groupBy("nfl.id")->orderBy('name', 'asc')->get()->toArray();
        return $titles;
    }

    // Get name of payment method in ascending order
    public function get_network_payment_list()
    {
        $select = [];
        $select[] = "pl.name";
        $select[] = DB::raw("COUNT(npm.network_id) as network_numbers");
        $titles = DB::table('payment_lists AS pl')->select($select)
            ->leftJoin('network_payment_method AS npm', "npm.payment_method", "=", "pl.id")
            ->groupBy("pl.id")->orderBy('name', 'asc')->get()->toArray();
        return $titles;
    }
    // Get ads image
    public function get_adspaces()
    {
        // return Adspace::get();
        // Get network of the months ads image
        $adspace = $this->get_networkofthemonths_ads();
        $all_ad = Adspace::all();
        $top_right = Adspace::where('position', 'top_right')->get();
        $right_side_2 = Adspace::where('position', 'right_side_2')->get();

        $adspaces = [
            'all_ad' => $all_ad,
            'top_right' => $top_right,
            'right_side_2' => $right_side_2,
            'adspace' => $adspace
        ];
        // dd($adspaces);
        return $adspaces;
    }
    // Get offers_adspaces on offers page
    public function get_offers_adspaces()
    {
        $offers_top_right = Adspace::where('position', 'offers_top_right')->get();
        $adspaces = [
            'offers_top_right' => $offers_top_right
        ];
        return $adspaces;
    }
    // Get reviews_adspaces on reviews page
    public function get_reviews_adspaces()
    {
        $reviews_top_right = Adspace::where('position', 'reviews_top_right')->get();
        $adspaces = [
            'reviews_top_right' => $reviews_top_right
        ];
        return $adspaces;
    }
    // Get Settings features like site logo,time zone,etc
    public function get_settings()
    {
        return SystemSettingModel::all();
    }
    // Get seo meta
    public function get_seo_meta()
    {
        $seo = SeoMeta::all();
        return $seo;
    }
    ###########################################
    // blogs and blogs view page
    ############################################
    // Get blogsViews page of blogs
    public function get_blogsview($filters = [])
    {

        $select = [];
        $select[] = "*";
        return DB::table('blogs AS b')->select($select)
            ->where('slug', $filters['slug'])
            ->first();
    }
    // Get blogs on blogs page
    public function get_blogs($filters = [], $paginate = false)
    {
        // select column
        $select = [];
        $select[] = "n.network_name";
        $select[] = "n.user_id";
        $select[] = "u.name";
        $select[] = "b.network_id";
        $select[] = "b.title";
        $select[] = "b.description";
        $select[] = "b.preview_image";
        $select[] = "b.category";
        $select[] = "b.add_user";
        $select[] = "b.update_user";
        $select[] = "b.status";
        $select[] = "b.sponsored";
        $select[] = "b.featured";
        $select[] = "b.meta_title";
        $select[] = "b.meta_description";
        $select[] = "b.tags";
        $select[] = "b.section";
        $select[] = "b.slug";
        $select[] = "b.created_at";
        $select[] = "b.updated_at";
        // joining table
        $query = DB::table('blogs AS b')->select($select)
            ->leftJoin('networks AS n', 'n.network_id', '=', 'b.network_id')
            ->leftJoin('users AS u', 'u.id', '=', 'n.user_id')
            ->orderBy('b.created_at', 'desc');


        // Get blogs according searching middle nav
        if (isset($filters['search_by']) && $filters['search_by'] == 'latest') {
            $query->orderBy('b.created_at', 'desc');
        }
        if (isset($filters['search_by']) && $filters['search_by'] == 'affiliate-network') {
            $query->where('b.section', 'Affiliate Network');
        }
        if (isset($filters['search_by']) && $filters['search_by'] == 'affiliates') {
            $query->where('b.section', 'Affiliates');
        }
        if (isset($filters['search_by']) && $filters['search_by'] == 'others') {
            $query->where('b.section', 'Others');
        }

        //pagination
        if (isset($filters['limit']) && $filters['limit'] > 0) {
            return $query->paginate($filters['limit']);
        } else {
            return $query->paginate(15);
        }
    }
    ###########################################
    // Offers page
    ############################################
    //Get offers ,latest offers and featured offers on offers page
    public function get_offers($filters = [], $paginate = false)
    {
        // select column
        $select = [];
        $select[] = "o.id";
        $select[] = "o.icon";
        $select[] = "o.title";
        $select[] = "o.offer_id";
        $select[] = "o.network_id";
        $select[] = "o.payout";
        $select[] = "o.countries";
        $select[] = "o.status";
        $select[] = "o.offer_image";
        $select[] = "o.currency";
        $select[] = "o.category";
        $select[] = "o.is_featured";
        $select[] = "o.created_at";
        $select[] = "o.updated_at";
        $select[] = "n.network_slug";
        $select[] = "n.network_name";
        // joining table
        $query = DB::table('offers AS o')->select($select)
            ->leftJoin('networks AS n', 'n.network_id', '=', 'o.network_id')
            ->orderBy('o.created_at', 'desc');

        // get only featured offers on offers page
        if (isset($filters['is_featured']) && $filters['is_featured'] == 1) {
            $query->where('o.is_featured', 1);
        }

        //pagination
        if (isset($filters['limit']) && $filters['limit'] > 0) {
            return $query->paginate($filters['limit']);
        } else {

            return $query->paginate(10);
        }
        // return $query->get();
    }

    // Get Top offers on offers page
    public function get_top_offers($paginate = false)
    {
        // select column
        $select = [];
        $select[] = "o.id";
        $select[] = "o.icon";
        $select[] = "o.title";
        $select[] = "o.offer_id";
        $select[] = "o.network_id";
        $select[] = "o.payout";
        $select[] = "o.countries";
        $select[] = "o.status";
        $select[] = "o.offer_image";
        $select[] = "o.currency";
        $select[] = "o.category";
        $select[] = "o.created_at";
        $select[] = "o.updated_at";
        $select[] = "n.network_slug";
        $select[] = "n.network_name";
        // joining table
        $query = DB::table('offers AS o')->select($select)
            ->leftJoin('networks AS n', 'n.network_id', '=', 'o.network_id')
            ->orderBy('o.payout', 'desc');
        // dd($query);
        return $query->get();
    }
    // get particular verticals on offers page
    public function get_offers_to_verticals($network_id = 1)
    {
        return DB::table('verticals AS v')
            ->leftJoin('network_verticals AS nv', "nv.vertical_id", "=", "v.id")
            ->where('nv.network_id', $network_id)
            ->orderBy('title', 'asc')->get(['icon', 'title'])->toArray();
    }

    // admin dashboard 
    // Get all_adspaces
    public function get_all_adspaces()
    {
        $select = [];
        $select[] = "ads.id";
        $select[] = "ads.position";
        $select[] = "ads.image_url";
        $select[] = "ads.link";
        $select[] = "ads.network_id";
        $select[] = "ads.expired_at";
        $select[] = "ads.status";
        $select[] = "n.network_name";
        $adspaces = DB::table('adspaces AS ads')->select($select)
            ->leftJoin('networks AS n', 'n.network_id', '=', 'ads.network_id')
            ->orderBy('ads.id', 'DESC');
        // dd($query);
        return $adspaces->get();
        // return response()->json($adspaces);
    }
    // Get network of the months ads image
    public function get_networkofthemonths_ads()
    {

        $select = [];
        $select[] = "ads.id";
        $select[] = "ads.image_url";
        $select[] = "ads.link";
        $select[] = "ads.network_id";
        $select[] = "n.network_name";
        $select[] = "n.network_description";
        $select[] = "n.rating";
        $select[] = "ads.expired_at";
        $select[] = "ads.status";
        $select[] = "ads.network_id";
        $adspaces = DB::table('adspaces AS ads')->select($select)
            ->leftJoin('networks AS n', 'n.network_id', '=', 'ads.network_id')
            ->where('position', 'top_left');
        // dd($query);
        return $adspaces->get();
    }
    // Get home page carousel ads image
    public function home_page_carousel_ads()
    {

        $select = [];
        $select[] = "ads.id";
        $select[] = "ads.image_url";
        $select[] = "ads.link";
        $select[] = "ads.network_id";
        $select[] = "n.network_name";
        $select[] = "ads.expired_at";
        $select[] = "ads.status";
        $select[] = "ads.network_id";
        $adspaces = DB::table('adspaces AS ads')->select($select)
            ->leftJoin('networks AS n', 'n.network_id', '=', 'ads.network_id')
            ->where('position', 'top_right');
        // dd($query);
        return $adspaces->get();
    }
    // Get in page ads image
    public function in_page_ads()
    {
        $select = [];
        $select[] = "ads.id";
        $select[] = "ads.image_url";
        $select[] = "ads.link";
        $select[] = "ads.network_id";
        $select[] = "n.network_name";
        $select[] = "ads.expired_at";
        $select[] = "ads.status";
        $select[] = "ads.network_id";
        $adspaces = DB::table('adspaces AS ads')->select($select)
            ->leftJoin('networks AS n', 'n.network_id', '=', 'ads.network_id')
            ->where('position', 'top_middle_1');
        // dd($query);
        return $adspaces->get();
    }
    // Get sponsored ads image
    public function sponsored_ads()
    {
        $select = [];
        $select[] = "ads.id";
        $select[] = "ads.image_url";
        $select[] = "ads.link";
        $select[] = "ads.network_id";
        $select[] = "n.network_name";
        $select[] = "ads.expired_at";
        $select[] = "ads.status";
        $select[] = "ads.network_id";
        $adspaces = DB::table('adspaces AS ads')->select($select)
            ->leftJoin('networks AS n', 'n.network_id', '=', 'ads.network_id')
            ->where('position', 'right_side_1');
        // dd($query);
        return $adspaces->get();
    }
    // Get sponsored small ads image
    public function sponsored_small()
    {
        $select = [];
        $select[] = "ads.id";
        $select[] = "ads.image_url";
        $select[] = "ads.link";
        $select[] = "ads.network_id";
        $select[] = "n.network_name";
        $select[] = "ads.expired_at";
        $select[] = "ads.status";
        $select[] = "ads.network_id";
        $adspaces = DB::table('adspaces AS ads')->select($select)
            ->leftJoin('networks AS n', 'n.network_id', '=', 'ads.network_id')
            ->where('position', 'right_side_2');
        // dd($query);
        return $adspaces->get();
    }
    // Get featured ads image
    public function featured_ads()
    {
        $select = [];
        $select[] = "ads.id";
        $select[] = "ads.image_url";
        $select[] = "ads.link";
        $select[] = "ads.network_id";
        $select[] = "n.network_name";
        $select[] = "ads.expired_at";
        $select[] = "ads.status";
        $select[] = "ads.network_id";
        $adspaces = DB::table('adspaces AS ads')->select($select)
            ->leftJoin('networks AS n', 'n.network_id', '=', 'ads.network_id')
            ->where('position', 'right_side_4');
        // dd($query);
        return $adspaces->get();
    }
    // Get all_reviews
    public function get_all_reviews()
    {
        $select = [];
        $select[] = "nr.review_id";
        $select[] = "nr.network_id";
        $select[] = "nr.user_id";
        $select[] = "nr.all_rating";
        $select[] = "nr.offer_rating";
        $select[] = "nr.payout_rating";
        $select[] = "nr.tracking_rating";
        $select[] = "nr.support_rating";
        $select[] = "nr.review_text";
        $select[] = "nr.status";
        $select[] = "n.network_name";
        $select[] = "u.name";
        $all_reviews = DB::table('network_review AS nr')->select($select)
            ->leftJoin('networks AS n', 'n.network_id', '=', 'nr.network_id')
            ->leftJoin('users AS u', 'u.id', '=', 'n.user_id')
            ->orderBy('nr.review_id', 'ASC');
        // dd($query);
        return $all_reviews->get();
    }
    // admin dashboard end
}
