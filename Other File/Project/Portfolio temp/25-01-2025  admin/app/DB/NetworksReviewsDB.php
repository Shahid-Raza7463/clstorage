<?php

namespace App\DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NetworksReviewsDB
{
    // get review of all networks on review page
    public function get_reviews($filters = [], $paginate = false)
    {
        // select column
        $select = [];
        $select[] = "n.network_id";
        $select[] = "n.network_name";
        $select[] = "n.network_slug";
        $select[] = "n.user_id";
        // $select[] = "nr.user_id";
        $select[] = "n.logo";
        $select[] = "n.rating";
        $select[] = "nr.all_rating";
        $select[] = "nr.offer_rating";
        $select[] = "nr.payout_rating";
        $select[] = "nr.tracking_rating";
        $select[] = "nr.support_rating";
        $select[] = "nr.review_text";
        $select[] = "nr.parent_review_id";
        $select[] = "nr.review_img";
        $select[] = "nr.review_id";
        $select[] = "u.name";
        $select[] = "nr.created_at";
        // joining table
        $query = DB::table('networks AS n')->select($select)
            ->leftJoin('network_review AS nr', 'nr.network_id', '=', 'n.network_id')
            ->leftJoin('users AS u', 'u.id', '=', 'n.user_id')
            ->orderBy('nr.created_at', 'desc')
            ->groupBy('n.network_id');
        // dd($query);

        // filter applied
        // get review that contain review id 
        if (empty($filters['nr.review_id'])) {
            $query->whereNotNull('nr.review_id');
        }

        if (isset($filters['parent_review_id']) && $filters['parent_review_id'] > 0) {
            $query->where('nr.parent_review_id', $filters['parent_review_id']);
        }

        if (isset($filters['network_id']) && $filters['network_id'] > 0) {
            $query->where('nr.network_id', $filters['network_id']);
        }


        //* get searching reviews
        if (isset($filters['searchReviews']) && $filters['searchReviews'] != '') {
            $query->where('network_name', 'LIKE', "%" . $filters['searchReviews'] . "%");
        }

        //pagination
        if (isset($filters['limit']) && $filters['limit'] > 0) {
            return $query->paginate($filters['limit']);
        } else {
            return $query->paginate(5);
        }
    }

    // get all review of  one network on network page
    public function get_network_review($filters = [])
    {
        // select column name 
        $select = [];
        $select[] = "n.network_name";
        $select[] = "nr.network_id";
        $select[] = "nr.user_id";
        $select[] = "n.logo";
        $select[] = "nr.all_rating";
        $select[] = "nr.offer_rating";
        $select[] = "nr.payout_rating";
        $select[] = "nr.tracking_rating";
        $select[] = "nr.support_rating";
        $select[] = "nr.review_text";
        $select[] = "nr.created_at";
        $select[] = "nr.review_img";
        $select[] = "nr.review_id";
        $select[] = "u.name";

        $query = DB::table('networks AS n')->select($select)
            ->leftJoin('network_review AS nr', 'nr.network_id', '=', 'n.network_id')
            ->leftJoin('users AS u', 'u.id', '=', 'nr.user_id');

        if (isset($filters['network_id']) && $filters['network_id'] > 0) {
            $query->where('nr.network_id', $filters['network_id']);
        }

        $query->where('nr.parent_review_id', 0);

        $query->orderBy('nr.created_at', 'desc');

        return $query->paginate(8);
    }
}
