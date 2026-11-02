<?php
// roles and permission 

use App\Console\Commands\OffersApi;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
// roles and permission end
use App\DB\NetworksDB;
use App\DB\NetworksDBController;
use App\Http\Controllers\Admin\AddJsController;
use App\Http\Controllers\Admin\AdspacesController;
use App\Http\Controllers\Admin\AdspacesImagesController;
use App\Http\Controllers\Admin\BlogsController;
use App\Http\Controllers\Admin\CommissionTypesController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\DbController;
use App\Http\Controllers\Admin\DummyController;
use App\Http\Controllers\Admin\NetworkRegisterController;
use App\Http\Controllers\Admin\NetworksController;
use App\Http\Controllers\Admin\NetworkSoftwaresController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\OffersApiController;
use App\Http\Controllers\Admin\OffersFetchController;
use App\Http\Controllers\Admin\PaymentMethodsController;
use App\Http\Controllers\Admin\PaymentsFrequencyController;
use App\Http\Controllers\Admin\ResourcesController;
use App\Http\Controllers\Admin\ReviewsController;
use App\Http\Controllers\Admin\SeoMetaController;
use App\Http\Controllers\Admin\SystemSettingsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\VerticalController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DisplayDataController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\AdspacesImagesWebController;
use App\Http\Controllers\Web\BlogsViewWebController;
use App\Http\Controllers\Web\BlogsWebController;
use App\Http\Controllers\Web\ContactUsWebController;
use App\Http\Controllers\Web\HomeWebController;
use App\Http\Controllers\Web\NetworkReviewsWebController;
use App\Http\Controllers\Web\NetworksWebController;
use App\Http\Controllers\Web\NetworkWebController;
use App\Http\Controllers\Web\OffersWebController;
use App\Http\Controllers\Web\ReplyWebController;
use App\Http\Controllers\Web\ResourcesWebController;
use App\Http\Controllers\Web\ReviewsWebController;
use App\Http\Controllers\Web\SearchWebController;
use App\Http\Controllers\Web\TemplateController;
use App\Http\Controllers\Web\UserCreatedEmailController;
use App\Jobs\AffmineOfferJob;
use App\Jobs\FuseClickOfferJob;
use App\Jobs\HasOffersJob;
use App\Jobs\Trakaff;
use App\Jobs\TrakaffJob;
use App\Jobs\TrakierOfferJob;
use App\Models\Admin\NetworkSoftware;
use App\Models\Admin\SystemSettingModel;
use App\Models\Web\Network;
use App\Models\Web\ReviewWebModel;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


//* admin panel
Route::prefix('admin')->middleware('throttle:only_three_time')->group(function () {
    // Preference tab
    Route::resource('commissiontype', CommissionTypesController::class);
    Route::resource('networksoftware', NetworkSoftwaresController::class);
    Route::resource('paymentfrequency', PaymentsFrequencyController::class);
    Route::resource('paymentmethod', PaymentMethodsController::class);
    Route::resource('verticals', VerticalController::class);
    //networks tab
    Route::resource('networks-list', NetworkRegisterController::class);
    Route::get('sponsored', [NetworkRegisterController::class, 'all_sponsored_networks']);
    Route::get('top-networks', [NetworkRegisterController::class, 'all_top_networks']);
    Route::get('featured-networks', [NetworkRegisterController::class, 'featured_networks']);
    //all ads route
    Route::resource('adspaces', AdspacesController::class);
    Route::get('network-ads', [AdspacesController::class, 'get_networkofthemonths_ads']);
    Route::get('carousel-ads', [AdspacesController::class, 'home_page_carousel_ads']);
    Route::get('inpage-ads', [AdspacesController::class, 'in_page_ads']);
    Route::get('sponsored-ads', [AdspacesController::class, 'sponsored_ads']);
    Route::get('sponsored-small', [AdspacesController::class, 'sponsored_small']);
    Route::get('featured-ads', [AdspacesController::class, 'featured_ads']);
    //all ads route end
    Route::resource('reviewslist', ReviewsController::class);
    Route::resource('resourcelist', ResourcesController::class);
    Route::resource('systemsettings', SystemSettingsController::class);
    Route::resource('seo-meta', SeoMetaController::class);
    Route::resource('blog', BlogsController::class);
    Route::resource('contact-us', ContactUsController::class);
    // Offers tab
    Route::resource('offers', OfferController::class);
    Route::get('latest-offers', [OfferController::class, 'get_latest_offers']);
    Route::get('top-offers', [OfferController::class, 'get_top_offers']);
    Route::get('featured-offers', [OfferController::class, 'get_featured_offers']);
    Route::resource('offers-api', OffersApiController::class);
    // Get bulk action
    Route::post('commissiontype/bulk-action', [CommissionTypesController::class, 'bulkAction'])->name('commissiontype.bulk-action');
    Route::post('networksoftware/bulk-action', [NetworkSoftwaresController::class, 'bulkAction'])->name('networksoftware.bulk-action');
    Route::post('paymentfrequency/bulk-action', [PaymentsFrequencyController::class, 'bulkAction'])->name('paymentfrequency.bulk-action');
    Route::post('paymentmethod/bulk-action', [PaymentMethodsController::class, 'bulkAction'])->name('paymentmethod.bulk-action');
    Route::post('verticals/bulk-action', [VerticalController::class, 'bulkAction'])->name('verticals.bulk-action');
    Route::post('offers-api/bulk-action', [OffersApiController::class, 'bulkAction'])->name('offers-api.bulk-action');
    Route::post('users/bulk-action', [UserController::class, 'bulkAction'])->name('users.bulk-action');
    Route::post('roles/bulk-action', [RoleController::class, 'bulkAction'])->name('roles.bulk-action');
    Route::post('systemsettings/bulk-action', [SystemSettingsController::class, 'bulkAction'])->name('systemsettings.bulk-action');
    Route::post('seo-meta/bulk-action', [SeoMetaController::class, 'bulkAction'])->name('seo-meta.bulk-action');
    Route::post('contact-us/bulk-action', [ContactUsController::class, 'bulkAction'])->name('contact-us.bulk-action');
    Route::post('blog/bulk-action', [BlogsController::class, 'bulkAction'])->name('blog.bulk-action');
    Route::post('reviewslist/bulk-action', [ReviewsController::class, 'bulkAction'])->name('reviewslist.bulk-action');
    Route::post('resourcelist/bulk-action', [ResourcesController::class, 'bulkAction'])->name('resourcelist.bulk-action');
    Route::post('adspaces/bulk-action', [AdspacesController::class, 'bulkAction'])->name('adspaces.bulk-action');
    Route::post('offers/bulk-action', [OfferController::class, 'bulkAction'])->name('offers.bulk-action');
    Route::post('networks-list/bulk-action', [NetworkRegisterController::class, 'bulkAction'])->name('networks-list.bulk-action');
});

//*user roles and permission
Route::group(['middleware' => ['auth']], function () {
    Route::prefix('admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        // Route::resource('products', ProductController::class);
    });
});
//* admin panel end hare


//* send email to user end hare

//*login routes start
Route::prefix('admin')->group(function () {
    Route::get('dashboard', function () {
        return view('Admin.template');
    })->middleware(['auth', 'verified'])->name('admin.dashboard');
});

// add this route in views/layouts/navigation.blade file route('admin.dashboard')
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('admin.dashboard');
    })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
//*login routes end
