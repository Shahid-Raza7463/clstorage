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

class HasOffersJob implements ShouldQueue
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
        // Get api_url of only HasOffers from tracking_software 
        $data = OfferApi::where('status', 1)->where('tracking_software', 'HasOffers')->first();
        // Get data from api 
        $response = Http::get($data->api_url);
        // Convert response to JSON array/object
        $responseData = $response->json();
        $offers = $responseData['response']['data']['data'];
        // dd($offers);
        foreach ($offers as $offerdata) {
            //Get country name 
            if (isset($offerdata['Country']) && is_array($offerdata['Country'])) {
                foreach ($offerdata['Country'] as $code => $countryInfo) {
                    $countryName = $countryInfo['name'];
                    // dd($countryName);
                    // Only take the first country
                    break;
                }
            }
            if (isset($offerdata['OfferCategory']) && is_array($offerdata['OfferCategory'])) {
                foreach ($offerdata['OfferCategory'] as $code => $category) {
                    $categoryName = $category['name'];
                    // dd($categoryName);
                    // Only take the first country
                    break;
                }
            }

            // insert 1 and 0 the status value
            $status = ($offerdata['Offer']['status'] === 'active') ? 1 : 0;
            // dd($offerdata['Offer']['currency']);
            //insert data in database
            OfferFetch::updateOrInsert([
                'title' => $offerdata['Offer']['name'],
                'offer_id' => $offerdata['Offer']['id'],
                'payout' => $offerdata['Offer']['default_payout'],
                'currency' => $offerdata['Offer']['currency'],
                'status' => $status,
                'countries' => $countryName,
                'category' => $categoryName,
            ]);
        }
        // return "Data inserted successfully!";
    }
}
