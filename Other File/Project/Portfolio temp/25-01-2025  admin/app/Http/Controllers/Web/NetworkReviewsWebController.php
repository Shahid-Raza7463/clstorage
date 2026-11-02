<?php

namespace App\Http\Controllers\Web;

use App\Events\Review\ReviewVerifyUser;
use App\DB\NetworksReviewsDB;
use App\Events\Admin\UserCreatedAdmin;
use App\Events\Review\ReviewCreatedAdmin;
use App\Events\Review\ReviewCreatedNetwork;
use App\Events\UserCreated;
use App\Events\VerifyEmailEvent;
use App\Http\Controllers\Controller;
use App\Jobs\ReviewRatingCounterJob;
use App\Models\Admin\AdspaceImages;
use App\Models\User;
use App\Models\Web\Network;
use App\Models\Web\NetworkReviewModel;
use App\Models\Web\PostModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class NetworkReviewsWebController extends Controller
{
    private NetworksReviewsDB $networksreviewsdb;
    function __construct()
    {
        $this->networksreviewsdb = new NetworksReviewsDB();
    }


    public function create()
    {
        return view('web.pages.network.network');
    }

    // write reviews form submitted
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' =>  'required',
            'network_id' =>  'required',
            'email' =>  'required|email',
            'all_rating' =>  'min:0|max:5',
            'offer_rating' =>  'min:0|max:5',
            'payout_rating' =>  'min:0|max:5',
            'tracking_rating' =>  'min:0|max:5',
            'support_rating' => 'min:0|max:5',
            'review_text' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $user = $this->createUser($request);
        }
        // create instance variable/object of networkreviewmodel
        $network_review = new NetworkReviewModel();
        $network_review->network_id = $request['network_id'];
        $network_review->all_rating = $request['all_rating'];
        $network_review->offer_rating = $request['offer_rating'];
        $network_review->payout_rating = $request['payout_rating'];
        $network_review->tracking_rating = $request['tracking_rating'];
        $network_review->support_rating = $request['support_rating'];
        $network_review->review_text = $request['review_text'];
        $network_review->review_img = $request['review_img'];

        // Assign the user ID only if it exists
        if ($user) {
            $network_review->user_id = $user->id;
        }
        // insert image path in table
        if ($request->hasFile('review_img')) {
            $path = $request->file('review_img')->store('images');
            $network_review->review_img = $path;
        }
        $network_review->save();

        // send email to user for verify review who given review
        event(new ReviewVerifyUser($user, $network_review));


        return ['success' => true];
    }

    // create users in users table(write reviews form)
    private function createUser(Request $request)
    {
        $user = $request->only(['name', 'email']);
        //pass password randomly
        $user['password'] =  Hash::make(rand(1, 1000));
        $newUser = User::create($user);

        // send User created email to user when create new user (using event)
        event(new UserCreated($newUser));

        // send verify email address to user when user created it is costume file
        // event(new VerifyEmailEvent($newUser));
        // Auth::login($newUser);

        // send User created email to admin when create new user (using event)
        $admins = User::role('admin')->get();
        event(new UserCreatedAdmin($admins, $newUser));
        return $newUser;
    }

    // path of image upload in database(write reviews form)
    public function upload(Request $request)
    {
        $path = $request->file('review_img')->store('images');
        NetworkReviewModel::insert($path);
    }



    //get verify review when user click on yes button
    public function verify_review(Request $request, $token)
    {
        $decryptedToken = Crypt::decryptString($token);
        // split value separately
        $tokenValues = explode("_", $decryptedToken);
        // store value individually
        list($review_id, $user_id, $network_id, $created_at) = $tokenValues;

        $network_review = NetworkReviewModel::where('review_id', $review_id)
            ->where('network_id', $network_id)
            ->where('user_id', $user_id)
            ->first();

        if ($network_review) {
            $network_review->status = 1;
            $network_review->save();

            //* email verify when user click yes button on email
            $user = User::where('id', $network_review->user_id)->first();
            $user->email_verified_at = $created_at;
            $user->save();

            //* send email to admin when user verify review
            $user = User::where('id', $network_review->user_id)->first();
            event(new ReviewCreatedAdmin($network_review, $user));


            // *send email to network user when user verify review
            // get user who given review
            $user = User::where('id', $network_review->user_id)->first();
            // get network to network user  
            $network = Network::where('network_id', $network_review->network_id)->first();
            event(new ReviewCreatedNetwork($network_review, $user,  $network));

            //* update count Review in networks table
            ReviewRatingCounterJob::dispatch($network_review->network_id);
        }
    }

    //get verify review when user click on No button
    public function reject_review(Request $request, $token)
    {
        $decryptedToken = Crypt::decryptString($token);
        // split value separately
        $tokenValues = explode("_", $decryptedToken);
        // store value individually
        list($review_id, $user_id, $network_id, $created_at) = $tokenValues;
        $network_review = NetworkReviewModel::where('review_id', $review_id)
            ->where('user_id', $user_id)
            ->where('network_id', $network_id)
            ->first();

        if ($network_review) {
            $network_review->status = 2;
            $network_review->save();

            // // send email to admin when user rejected review
            // $user = User::where('id', $network_review->user_id)->first();
            // event(new ReviewCreatedAdmin($network_review, $user));
        }
    }


    // get reviews of all networks on review page
    public function get_reviews($filters = [])
    {
        // use in resourcewebcontrooler
        // use in searchwebcontrooler
        $networks_review = $this->networksreviewsdb->get_reviews($filters, true);
        return $networks_review;
        // comment $filters for get to searching
        // $filters = ['nr.review_id' => '', 'limit' => 8];
    }

    // Get searching reviews
    public function get_search_reviews($filters = [])
    {
        // pagination
        $filters['limit'] = isset($filters['limit']) ? $filters['limit'] : 5;
        $search_reviews =  $this->networksreviewsdb->get_reviews($filters, true);
        return $search_reviews;
    }

    //get all review of one network on network page
    public function get_network_review($network_id)
    {
        // use in networkwebcontroller
        $reviews =  $this->networksreviewsdb->get_network_review(['network_id' => $network_id]);
        return $reviews;
    }
}
