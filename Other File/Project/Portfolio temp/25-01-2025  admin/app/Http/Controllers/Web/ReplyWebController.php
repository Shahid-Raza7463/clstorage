<?php

namespace App\Http\Controllers\Web;

use App\DB\NetworksReviewsDB;
use App\Events\Admin\UserCreatedAdmin;
use App\Events\Replies\RepliesCreatedAdmin;
use App\Events\Replies\RepliesCreatedNetwork;
use App\Events\Replies\RepliesVerifyUser;
use App\Events\Review\ReviewVerifyUser;
use App\Events\UserCreated;
use App\Events\VerifyEmailEvent;
use App\Http\Controllers\Controller;
use App\Jobs\ReviewRatingCounterJob;
use App\Models\User;
use App\Models\Web\Network;
use App\Models\Web\NetworkReviewModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ReplyWebController extends Controller
{

    //    reply form submitted
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' =>  'required',
            'email' =>  'required|email',
            'review_text' => 'required',
            // below validation is hidden in form
            'network_id' =>  'required',
            'user_id' =>  'required',
            'parent_review_id' =>  'required',
        ]);
        // $id = $this->createUser($request);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $user = $this->createUser($request);
        }
        $network_review = new NetworkReviewModel();
        $network_review->network_id = $request['network_id'];
        $network_review->user_id = $request['user_id'];
        $network_review->parent_review_id = $request['parent_review_id'];
        $network_review->review_text = $request['review_text'];

        // Assign the user ID only if it exists
        if ($user) {
            $network_review->user_id = $user->id;
        }

        $network_review->save();


        // send email to user for verify review who given review
        event(new RepliesVerifyUser($user, $network_review));

        // it is used in jquery ajax for send on thankyou page
        return ['success' => true];
        // return response()->json(['success' => true]);
    }

    // create users when email not exist in users table
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

    // Send email to verify replies when user click on yes button
    public function verify_replies(Request $request, $token)
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

            //* send email to admin when user verify review done
            $user = User::where('id', $network_review->user_id)->first();
            event(new RepliesCreatedAdmin($network_review, $user));


            //* send email to network user when user verify review done
            // get user who given review
            $user = User::where('id', $network_review->user_id)->first();
            // get network to network user  
            $network = Network::where('network_id', $network_review->network_id)->first();
            event(new RepliesCreatedNetwork($network_review, $user,  $network));

            //* update count Review in networks table
            ReviewRatingCounterJob::dispatch($network_review->network_id);
        }
    }

    // Send email to verify replies when user click on no button
    public function reject_replies(Request $request, $token)
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
            // event(new RepliesCreatedAdmin($network_review, $user));
        }
    }


    // Get all reply of one reviews on network page using ajax
    public function get_reply_Review($parent_review_id)
    {
        $select = [];
        $select[] = "n.network_name";
        $select[] = "nr.network_id";
        $select[] = "nr.user_id";
        $select[] = "nr.parent_review_id";
        $select[] = "nr.review_text";
        $select[] = "nr.status";
        $select[] = "nr.created_at";
        $select[] = "nr.review_img";
        $select[] = "nr.review_id";
        $select[] = "u.name";
        $select[] = "u.email";

        $replies = DB::table('networks AS n')->select($select)
            ->leftJoin('network_review AS nr', 'nr.network_id', '=', 'n.network_id')
            ->leftJoin('users AS u', 'u.id', '=', 'nr.user_id')
            ->where('parent_review_id', $parent_review_id)
            ->get();
        // dd($replies);
        return $replies;
    }
}
