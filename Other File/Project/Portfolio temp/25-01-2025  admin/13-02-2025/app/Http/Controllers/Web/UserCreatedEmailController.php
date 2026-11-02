<?php

namespace App\Http\Controllers\Web;

//?  this controller only for testing (email related)

use App\Events\AfterVerifyNetwork;
use App\Events\NetworkApproved;
use App\Events\NetworkCreated;
use App\Events\NetworkRejected;
use App\Events\UserCreated;
use App\Http\Controllers\Controller;
use App\Models\Web\Network;
use App\Models\User;
use App\Models\Web\NetworkReviewModel;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UserCreatedEmailController extends Controller
{
    //?  this controller only for testing (email related)
    // user created
    public function index()
    {
        $newUser = User::find(3);
        event(new UserCreated($newUser));
    }
    // after network verification when click on yes, i conform button
    public function after_network_verification()
    {
        $user = User::find(3);
        event(new AfterVerifyNetwork($user));
    }

    // network Created 
    public function network_created()
    {
        $network = Network::find(3);
        $user = User::where('id', $network->user_id)->find(4);
        event(new NetworkCreated($user, $network));
    }
    public function network_approved()
    {
        $network = Network::find(3);
        if ($network->status == 1) {
            $newUser = User::find($network->user_id);
            event(new NetworkApproved($newUser));
            // event(new NetworkApproved($user, $network));
        } else {
            $newUser = User::find($network->user_id);
            event(new NetworkRejected($newUser));
        }
    }


    public function network_rejected()
    {
        $network = Network::find(3);
        if ($network->status == 0) {
            $newUser = User::find($network->user_id);
            event(new NetworkRejected($newUser));
        }
    }

    // 1.verify the user email
    public function verify_email()
    {
        $newUser = User::find(2);
        event(new Registered($newUser));
        Auth::login($newUser);
    }
    //!working on reply module
    // send email to admin when reply created
    public function reply_created()
    {
        $review = NetworkReviewModel::find(278);
        $user = User::where('id', $review->user_id)->get();
        $admins = User::role('admin')->get();
        // event(new NetworkCreated($review, $user, $admins));
    }

    // send email to user when reply created for verification
    public function reply_created_user()
    {
        $review = NetworkReviewModel::find(278);
        $user = User::where('id', $review->user_id)->get();
        // event(new NetworkCreated($review, $user, $admins));
    }
    // send email to network owner
    public function reply_created_network()
    {
        $review = NetworkReviewModel::find(278);
        $user = User::where('id', $review->user_id)->get();
        $network = Network::where('network_id', $review->network_id)
            ->get();
        $networkUser = User::find($network[0]['user_id']);
        dd($networkUser);
        // event(new NetworkCreated($review, $user,  $network));
    }

    //? review verify
    public function reply_verify_user()
    {
        $review = NetworkReviewModel::find(278);
        $user = User::where('id', $review->user_id)->get();
        // event(new NetworkCreated($review, $user, $admins));
    }

    //? 
    public function rating()
    {
        $network_id = 1;
        $averageRating = NetworkReviewModel::where('network_id', $network_id)->avg('all_rating');
        dd($averageRating);
    }

    // count network categories
    public function count_networks()
    {
        $select = [];
        $select[] = "ns.name";
        $select[] = DB::raw("COUNT(n.network_id) as network_numbers");
        $titles = DB::table('network_softwares AS ns')->select($select)
            ->leftJoin('networks AS n', "n.affiliate_tracking_software", "=", "ns.name")
            ->groupBy("ns.name")->orderBy('name', 'asc')->get()->toArray();
        return $titles;
    }
}
