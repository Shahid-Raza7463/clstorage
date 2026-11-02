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

class InHouseJob implements ShouldQueue
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
        // Get api_url of only In house from tracking_software 
        $data = OfferApi::where('status', 1)->where('tracking_software', 'In house')->first();
        // Get data from api 
        $response = Http::get($data->api_url);

        // Convert response to JSON array/object
        $responseData = $response->json();
        // dd($responseData);
        // Get the 'response' array
        $offers = $responseData['response'];
        foreach ($offers as $offerdata) {
            // fetch payout array
            $payouts = $offerdata['payout']['offer_payouts'];

            OfferFetch::create([
                'icon' => $offerdata['offer']['icon'],
                'title' => $offerdata['offer']['title'],
                'offer_id' => $offerdata['offer']['offer_id'],
                'status' => $offerdata['offer']['status'],
                'payout' => $payouts[0]['payout'],
                'countries' => $payouts[0]['offer_country']
                // 'offer_image' => $offerdata['offer']['icon']
            ]);
        }

        // return "Data inserted successfully!";
    }
}
