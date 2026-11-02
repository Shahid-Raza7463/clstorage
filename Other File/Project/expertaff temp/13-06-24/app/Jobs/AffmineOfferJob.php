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

class AffmineOfferJob implements ShouldQueue
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
        $data = OfferApi::where('status', 1)->where('tracking_software', 'Affmine')->first();
        // Get data from api 
        $response = Http::get($data->api_url);

        // Convert response to JSON array/object
        $responseData = $response->json();
        // Get the 'response' array
        $offers = $responseData['offer_feed']['offers'];
        foreach ($offers as $offerdata) {
            // dd($offerdata);
            // fetch payout array
            $countries = $offerdata['countries']['country'];
            OfferFetch::updateOrInsert([
                'title' => $offerdata['name'],
                'offer_id' => $offerdata['offer_id'],
                'payout' => $offerdata['payout'],
                'status' => $offerdata['offer_status'],
                'countries' => $countries['country_name'],
                'currency' => $offerdata['currency'],
                'category' => $offerdata['category']
            ]);
        }

        // return "Data inserted successfully!";
    }
}
