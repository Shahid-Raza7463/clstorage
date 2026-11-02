<?php

namespace App\Http\Controllers\Admin;

use App\Events\Admin\FeaturedEvent;
use App\Events\Admin\NetworkApprovedAdmin;
use App\Events\Admin\NetworkCreatedAdmin;
use App\Events\Admin\NetworkRejectedAdmin;
use App\Events\Admin\SponsoredEvent;
use App\Events\Admin\TopNetworkEvent;
use App\Events\Admin\UserCreatedAdmin;
use App\Events\FeaturedUserEvent;
use App\Events\NetworkApproved;
use App\Events\NetworkCreated;
use App\Events\NetworkRejected;
use App\Events\SponsoredUserEvent;
use App\Events\TopNetworkUserEvent;
use App\Events\UserCreated;
use App\Events\VerifyEmailEvent;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\NetworkWebController;
use App\Models\Admin\NetworkModel;
use Illuminate\Http\Request;
use App\Models\Web\Network;
use App\Models\Web\NetworkCommissionList;
use App\Models\Web\NetworkCommissionType;
use App\Models\Web\NetworkfrequencyList;
use App\Models\Web\NetworkPaymentList;
use App\Models\Web\NetworkPaymentMethod;
use App\Models\Web\NetworkPayoutFrequencyi;
use App\Models\Web\NetworkSocialPage;
use App\Models\Web\NetworkSoftware;
use App\Models\Web\NetworkVertical;
use App\Models\Admin\SocialSiteListList;
use App\Models\Web\UserDetail;
use App\Models\Admin\VerticalModel;
use App\Models\User;
use App\Models\Web\UserDetail as WebUserDetail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class NetworksController extends Controller
{
    //? this controller related to web page for network create
    // function for create Network
    public function create(NetworkWebController $nwc)
    {
        // Get ads image
        $adspace_image = $nwc->get_adspaces();
        // get web logo 
        $web_logo =  $nwc->get_settings();
        // Get seo_meta
        $seo_meta =  $nwc->get_seo_meta();
        $data = [];

        $data['verticals'] = VerticalModel::pluck('title', 'id'); //all();

        $data['network_softwares'] = NetworkSoftware::pluck('name', 'id');

        $data['commission_type'] = NetworkCommissionList::pluck('name', 'id');

        $data['payment_method'] = NetworkPaymentList::pluck('name', 'id');
        $data['payment_frequency'] = NetworkfrequencyList::pluck('name', 'id');
        // for adspace image
        $data['adspace_image'] = $adspace_image;
        $data['web_logo'] = $web_logo;
        $data['seo_meta'] = $seo_meta;
        return view('web.pages.register.register', $data);
    }
    // function for store Network
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'network_name' =>  'required|unique:networks|max:255',
            'network_type' => 'required',
            'network_url' => 'required|active_url',
            'network_description' => 'required',
            'offer_count' => 'required',
            'vertical_id'  => 'required',
            'vertical_id.*'  => 'required',
            'commission_type'  => 'required',
            'commission_type.*'  => 'required',
            'min_payout' => 'required',
            'payment_frequency' => 'required|min:1',
            'payment_frequency.*' => 'required|min:1',
            'payment_method' => 'required',
            'payment_method.*' => 'required',
            'affiliate_tracking_software' => 'required',
            'social_site' => 'required',
            'social_site.*' => 'required',
            'social_link' => 'required',
            'social_link.*' => 'required',
            'name'  => 'required',
            'email' =>  'required|unique:users|max:255|email',
            'phone_number'  => 'required',
            'image' => 'required|image|max:2048',

        ]);

        // for recapcha
        // $validator = Validator::make($request->all(), [
        //     'g-recaptcha-response' => 'required|captcha',
        //     // Your other validation rules here
        // ]);

        // if ($validator->fails()) {
        //     // Handle validation errors
        //     return 'recapcha';
        // }

        // Process the form submission

        $id = $this->createUser($request);
        // send Usercreated email to user when create new user (using event)
        $newUser = User::find($id);
        //send mail when user created 
        // event(new UserCreated($newUser));

        // send verify email address to user when usercreated it is costume file
        event(new VerifyEmailEvent($newUser));
        Auth::login($newUser);

        // send Usercreated email to admin when create new user (using event)
        $admins = User::role('admin')->get();
        event(new UserCreatedAdmin($admins, $newUser));

        $this->createUserDetails($request, $id);
        $this->createNetwork($request, $id);

        return ['success' => true];
    }





    //for select box of social site so that multiple selected value can be added in database
    public function set_social_sites(Request $req, $network_id = 0)
    {
        $social_sites = $req->input('social_site');
        $social_links = $req->input('social_link');

        $ss = [];
        foreach ($social_sites as $key => $value) {
            $ss[] = [
                'network_id' => $network_id,
                'social_site' => $value,
                'social_link' => $social_links[$key],
            ];
        }

        //
        NetworkSocialPage::insert($ss);
    }
    //for select box of verticals so that multiple selected value can be added in database
    public function set_verticals(Request $req, $network_id = 0)
    {
        $vertical_id = $req->input('vertical_id');

        $ss = [];
        foreach ($vertical_id as $key => $value) {
            $ss[] = [
                'network_id' => $network_id,
                'vertical_id' => $value,
            ];
        }
        //
        NetworkVertical::insert($ss);
    }



    //for select box of commission type so that multiple selected value can be added in database
    public function set_networks_commission(Request $req, $id)
    {
        $commission_type = $req->input('commission_type');

        $ss = [];
        foreach ($commission_type as $key => $value) {
            $ss[] = [

                'network_id' => $id,
                'commission_type' => $value,
            ];
        }
        //11

        NetworkCommissionType::insert($ss);
    }

    //for select box of payment method so that multiple selected value can be added in database
    public function set_networks_payment(Request $req, $id)
    {
        $payment_method = $req->input('payment_method');

        $ss = [];
        foreach ($payment_method as $key => $value) {
            $ss[] = [
                'network_id' => $id,
                'payment_method' => $value,
            ];
        }
        //11
        NetworkPaymentMethod::insert($ss);
    }


    public function set_payout_frequency(Request $req, $id)
    {
        $payment_frequency = $req->input('payment_frequency');

        $ss = [];
        foreach ($payment_frequency as $key => $value) {
            $ss[] = [
                'network_id' => $id,
                'payment_frequency' => $value,
            ];
        }
        NetworkPayoutFrequencyi::insert($ss);
    }
    // insert path of image
    public function upload(Request $request)
    {
        $path = $request->file('image')->store('images');
        Network::insert($path);
    }

    //for users table 
    private function createUser(Request $request)
    {
        $user = $request->only(['name', 'email']);
        $user['password'] = Hash::make(rand(1, 1000));
        $newUser = User::create($user);
        return $newUser->id;
    }
    // $id = $this->createUser($request); already called in store method

    private function createUserDetails(Request $request, $id)
    {
        $userDetails = $request->all();
        $userDetails['user_id'] = $id;
        $userDetails = UserDetail::create($userDetails);
    }
    // $this->createUserDetails($request, $id); already called in store method

    // important function for create network
    private function createNetwork(Request $request, $id)
    {
        $networks = $request->all();
        $networks['user_id'] = $id;

        $path = $request->file('image')->store('images');
        $networks['logo'] = $path;
        // insert slug in database 
        $networks['network_slug'] = strtolower(str_replace(' ', '-', $networks['network_name']));

        $network = Network::create($networks);

        $this->set_social_sites($request, $network->network_id);
        $this->set_verticals($request, $network->network_id);
        $this->set_networks_commission($request, $network->network_id);
        $this->set_networks_payment($request, $network->network_id);
        $this->set_payout_frequency($request, $network->network_id);

        // send email to user networkcreated email when network created
        $user = User::where('id', $network->user_id)->find($id);
        event(new NetworkCreated($user, $network));

        // send email to admin networkcreated email when network created
        $admins = User::role('admin')->get();
        event(new NetworkCreatedAdmin($admins, $user, $network));
    }
    // function for edit Network
    public function edit(string $network_id)
    {
        $data = [];
        $data['network_softwares'] = NetworkSoftware::pluck('name', 'id');
        $data['network'] = Network::where('network_id', $network_id)->first();
        $data['network_id'] = $network_id;
        return view('Admin.networks.update_networks', $data);
    }

    // function for update Network
    public function update(Request $request, string $network_id)
    {
        //
        $validated = $request->validate([
            'network_name' =>  "required|unique:networks,network_id," . $network_id . ",network_id|max:255",
            'network_type' => 'required',
            'network_url' => 'required',
            'network_description' => 'required',
            'offer_count' => 'required',
            'min_payout' => 'required',
            'referral_commission' => 'required',
            'affiliate_tracking_software' => 'required',
            'social_site.*' => 'required',
            'social_link.*' => 'required',
        ]);

        $network = Network::where('network_id', $network_id)->first();
        $network->network_name = $request->input('network_name');
        $network->network_type = $request->input('network_type');
        $network->network_url = $request->input('network_url');
        $network->network_description = $request->input('network_description');
        $network->offer_count = $request->input('offer_count');
        $network->min_payout = $request->input('min_payout');
        $network->referral_commission = $request->input('referral_commission');
        $network->affiliate_tracking_software = $request->input('affiliate_tracking_software');
        $network->other_optional_questions = $request->input('other_optional_questions');
        // when value of is_sponsored change then send mail otherwise not
        if ($network->is_sponsored != $request->input('is_sponsored')) {
            $network->is_sponsored = $request->input('is_sponsored');
            $this->set_sponsored_network($network);
        }
        // when value of is_top_network change then send mail otherwise not
        if ($network->is_top_network != $request->input('is_top_network')) {
            $network->is_top_network = $request->input('is_top_network');
            $this->set_top_network($network);
        }
        // when value of is_featured change then send mail otherwise not
        if ($network->is_featured != $request->input('is_featured')) {
            $network->is_featured = $request->input('is_featured');
            $this->set_featured_network($network);
        }
        // when value of status change then send mail otherwise not
        if ($network->status != $request->input('status')) {
            $network->status = $request->input('status');
            // send mail to user and admin when network rejected/approved
            $this->network_approved($network);
        }
        $network->save();

        return redirect('admin/networks')->with('message', 'Your data successfully updated');
    }

    // send mail to user when network rejected/approved
    public function network_approved($network)
    {
        if ($network->status == 1) {
            $newUser = User::find($network->user_id);
            event(new NetworkApproved($newUser));

            // send email to admin network created email when network created
            $admins = User::role('admin')->get();
            event(new NetworkApprovedAdmin($admins, $newUser));
        } elseif ($network->status == 2) {
            $newUser = User::find($network->user_id);
            event(new NetworkRejected($newUser));

            // send email to admin network created email when network created
            $admins = User::role('admin')->get();
            event(new NetworkRejectedAdmin($admins, $newUser));
        }
    }

    // send mail to user when set sponsored network
    public function set_sponsored_network($network)
    {
        if ($network->is_sponsored == 1) {
            // send email to user
            $user = User::find($network->user_id);
            event(new SponsoredUserEvent($user));

            // send email to admin
            event(new SponsoredEvent($user));
        }
    }
    // send mail to user when set top network
    public function set_top_network($network)
    {
        if ($network->is_top_network == 1) {
            // send email to user
            $user = User::find($network->user_id);
            event(new TopNetworkUserEvent($user));

            // send email to admin
            event(new TopNetworkEvent($user));
        }
    }
    // send mail to user when set Featured
    public function set_featured_network($network)
    {
        if ($network->is_featured == 1) {
            // send email to user
            $user = User::find($network->user_id);
            event(new FeaturedUserEvent($user));

            // send email to admin
            event(new FeaturedEvent($user));
        }
    }
}
