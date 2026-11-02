<?php

namespace App\Console\Commands;

use App\Http\Controllers\Web\NetworkWebController;
use App\Jobs\AffiseJob;
use App\Jobs\AffmineOfferJob;
use App\Jobs\FuseClickOfferJob;
use App\Jobs\HasOffersJob;
use App\Jobs\InHouseJob;
use App\Jobs\TrakaffJob;
use App\Jobs\TrakierOfferJob;
use App\Models\Admin\OfferApi;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OffersApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:offers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'All offers Api fetching';

    /**
     * Execute the console command.
     */
    public function handle(NetworkWebController $nwc)
    {
        $data = OfferApi::where('status', 1)->get(['api_url', 'tracking_software']);
        // dd($data);
        $trakaff = 'Trakaff';
        $affise = 'Affise';
        $inHouse = 'In house';
        $hasOffers = 'HasOffers';
        $affmine = 'Affmine';
        $fuseclick = 'Fuseclick';
        $trakier = 'Trakier';
        foreach ($data as $d) {
            if ($trakaff == $d->tracking_software) {
                TrakaffJob::dispatch();
            } elseif ($affmine == $d->tracking_software) {
                AffmineOfferJob::dispatch();
            } elseif ($fuseclick == $d->tracking_software) {
                FuseClickOfferJob::dispatch();
            } elseif ($trakier == $d->tracking_software) {
                TrakierOfferJob::dispatch();
            } elseif ($hasOffers == $d->tracking_software) {
                HasOffersJob::dispatch();
            } else {
                echo "Not found Api";
            }
        }
        // dd($massage);

        // $this->info('success');
    }
}
