<?php

namespace App\Jobs;

use App\Models\Admin\OfferApi;
use App\Models\Admin\OfferFetch;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class FuseClickOfferJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get api_url of only Trakaff from tracking_software 
        $data = OfferApi::where('status', 1)->where('tracking_software', 'Fuseclick')->first();
        // Get data from api 
        $response = Http::get($data->api_url);

        // Convert response to JSON array/object
        $responseData = $response->json();
        // Get the 'response' array
        $offers = $responseData['data']['content'];
        // dd($offers);
        foreach ($offers as $offerdata) {

            // insert 1 and 0 status value
            $status = ($offerdata['status'] === 'Active') ? 1 : 0;

            OfferFetch::updateOrInsert([
                // 'icon' => $offerdata['offer_id'],
                'title' => $offerdata['name'],
                'offer_id' => $offerdata['id'],
                'payout' => $offerdata['payout'],
                'currency' => $offerdata['currency'],
                'status' => $status,
                'countries' => $offerdata['geo_countries'],
            ]);
        }
        // return "Data inserted successfully!";
    }
}
