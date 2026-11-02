<?php

namespace App\Jobs;

use App\Models\Web\Network;
use App\Models\Web\NetworkReviewModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ReviewRatingCounterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $network_id = [];

    public function __construct($network_id = [])
    {
        $this->network_id = $network_id;
    }

    public function handle(): void
    {
        $select = [];
        $select[] = "nr.network_id";
        $select[] = DB::raw("ROUND(SUM(nr.all_rating)/COUNT(nr.network_id),2) AS all_rating");
        $select[] = DB::raw("ROUND(SUM(nr.offer_rating)/COUNT(nr.network_id),2) AS offer_rating");
        $select[] = DB::raw("ROUND(SUM(nr.tracking_rating)/COUNT(nr.network_id),2) AS tracking_rating");
        $select[] = DB::raw("ROUND(SUM(nr.support_rating)/COUNT(nr.network_id),2) AS support_rating");
        $select[] = DB::raw("ROUND(SUM(nr.payout_rating)/COUNT(nr.network_id),2) AS payout_rating");

        $select[] = DB::raw("SUM(CASE
    WHEN nr.parent_review_id=0 THEN 1
    ELSE 0
END) AS review_count");
        $db = DB::table('network_review AS nr')
            ->select($select);

        // dd($this->network_id)
        if (!empty($this->network_id)) {
            $db->wherein('nr.network_id', $this->network_id);
        }

        $db = $db->groupBy('nr.network_id');
        $result = $db->get()->toArray();
        dd($result);

        // Update the Network table
        DB::table('networks')->upsert([
            [
                'rating' => $result[0]->all_rating,
                'offer_ratings' => $result[0]->offer_rating,
                'tracking_ratings' => $result[0]->tracking_rating,
                'support_ratings' => $result[0]->support_rating,
                'payout_ratings' => $result[0]->payout_rating,
                'review_count' => $result[0]->review_count,
            ],
        ], 'network_id');
    }
}
