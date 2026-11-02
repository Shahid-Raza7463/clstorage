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

class TrakierOfferJob implements ShouldQueue
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
        $data = OfferApi::where('status', 1)->where('tracking_software', 'Trakier')->first();
        // Get data from api 
        $response = Http::get($data->api_url);
        // Convert response to JSON array/object
        $responseData = $response->json();
        // Get the 'response' array
        $offers = $responseData['data']['campaigns'];
        // dd($offers);

        foreach ($offers as $offerdata) {
            // $hi = $offerdata['countries'][0];
            OfferFetch::updateOrInsert([
                'title' => $offerdata['title'],
                'payout' => $offerdata['payouts'][0]['payout'],
                'offer_id' => $offerdata['id'],
                'currency' => $offerdata['currency'],
                'countries' => $offerdata['countries'][0],
            ]);
        }

        // return "Data inserted successfully!";
    }
}
