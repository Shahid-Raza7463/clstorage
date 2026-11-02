<?php

use App\Console\Commands\OffersApi;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
// roles and permission end
use App\DB\NetworksDB;
use App\DB\NetworksDBController;
use App\DB\NetworksReviewsDB;
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
use App\Jobs\ReviewRatingCounterJob;
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


//? admin panel
Route::prefix('admin')->middleware('throttle:only_three_time')->group(function () {
    // Show Commission type
    Route::resource('commissiontype', CommissionTypesController::class);
    // Show network software
    Route::resource('networksoftware', NetworkSoftwaresController::class);
    // Show payment frequency
    Route::resource('paymentfrequency', PaymentsFrequencyController::class);
    // Show payment method
    Route::resource('paymentmethod', PaymentMethodsController::class);
    // Show verticals
    Route::resource('verticals', VerticalController::class);
    // Show all reviews
    Route::resource('reviewslist', ReviewsController::class);
    // Show all resources data
    Route::resource('resourcelist', ResourcesController::class);
    // Show settings featured
    Route::resource('systemsettings', SystemSettingsController::class);
    // Show seo meta 
    Route::resource('seo-meta', SeoMetaController::class);
    // Show all blogs 
    Route::resource('blog', BlogsController::class);
    // Show contact us data
    Route::resource('contact-us', ContactUsController::class);

    //* all networks route start
    // Show networks
    Route::resource('networks-list', NetworkRegisterController::class);
    // Show sponsored networks
    Route::get('sponsored', [NetworkRegisterController::class, 'all_sponsored_networks']);
    // Show top networks
    Route::get('top-networks', [NetworkRegisterController::class, 'all_top_networks']);
    // Show featured networks
    Route::get('featured-networks', [NetworkRegisterController::class, 'featured_networks']);
    //* all networks route end

    //* all ads route start 
    // Show all ads image 
    Route::resource('adspaces', AdspacesController::class);
    // Show network of the months image
    Route::get('network-ads', [AdspacesController::class, 'get_networkofthemonths_ads']);
    // Show carousel ads image 
    Route::get('carousel-ads', [AdspacesController::class, 'home_page_carousel_ads']);
    // Show in page ads image 
    Route::get('inpage-ads', [AdspacesController::class, 'in_page_ads']);
    // Show sponsored ads image 
    Route::get('sponsored-ads', [AdspacesController::class, 'sponsored_ads']);
    // Show sponsored small ads image 
    Route::get('sponsored-small', [AdspacesController::class, 'sponsored_small']);
    // Show featured ads image 
    Route::get('featured-ads', [AdspacesController::class, 'featured_ads']);
    //* all ads route end

    //* all offers route start 
    // Show all offers 
    Route::resource('offers', OfferController::class);
    // Show latest offers
    Route::get('latest-offers', [OfferController::class, 'get_latest_offers']);
    // Show top offers
    Route::get('top-offers', [OfferController::class, 'get_top_offers']);
    // Show featured offers
    Route::get('featured-offers', [OfferController::class, 'get_featured_offers']);
    // Show all offers api
    Route::resource('offers-api', OffersApiController::class);
    //* all offers route end 

    //* all bulk action route start
    // Get commission type bulk action
    Route::post('commissiontype/bulk-action', [CommissionTypesController::class, 'bulkAction'])->name('commissiontype.bulk-action');
    // Get network software bulk action
    Route::post('networksoftware/bulk-action', [NetworkSoftwaresController::class, 'bulkAction'])->name('networksoftware.bulk-action');
    // Get payment frequency bulk action
    Route::post('paymentfrequency/bulk-action', [PaymentsFrequencyController::class, 'bulkAction'])->name('paymentfrequency.bulk-action');
    // Get payment method bulk action
    Route::post('paymentmethod/bulk-action', [PaymentMethodsController::class, 'bulkAction'])->name('paymentmethod.bulk-action');
    // Get verticals bulk action
    Route::post('verticals/bulk-action', [VerticalController::class, 'bulkAction'])->name('verticals.bulk-action');
    // Get offers api bulk action
    Route::post('offers-api/bulk-action', [OffersApiController::class, 'bulkAction'])->name('offers-api.bulk-action');
    // Get users bulk action
    Route::post('users/bulk-action', [UserController::class, 'bulkAction'])->name('users.bulk-action');
    // Get roles bulk action
    Route::post('roles/bulk-action', [RoleController::class, 'bulkAction'])->name('roles.bulk-action');
    // Get settings featured bulk action
    Route::post('systemsettings/bulk-action', [SystemSettingsController::class, 'bulkAction'])->name('systemsettings.bulk-action');
    // Get seo meta bulk action
    Route::post('seo-meta/bulk-action', [SeoMetaController::class, 'bulkAction'])->name('seo-meta.bulk-action');
    // Get contact us bulk action
    Route::post('contact-us/bulk-action', [ContactUsController::class, 'bulkAction'])->name('contact-us.bulk-action');
    // Get blogs bulk action
    Route::post('blog/bulk-action', [BlogsController::class, 'bulkAction'])->name('blog.bulk-action');
    // Get reviews bulk action
    Route::post('reviewslist/bulk-action', [ReviewsController::class, 'bulkAction'])->name('reviewslist.bulk-action');
    // Get resource bulk action
    Route::post('resourcelist/bulk-action', [ResourcesController::class, 'bulkAction'])->name('resourcelist.bulk-action');
    // Get ads image bulk action
    Route::post('adspaces/bulk-action', [AdspacesController::class, 'bulkAction'])->name('adspaces.bulk-action');
    // Get offers bulk action
    Route::post('offers/bulk-action', [OfferController::class, 'bulkAction'])->name('offers.bulk-action');
    // Get networks bulk action
    Route::post('networks-list/bulk-action', [NetworkRegisterController::class, 'bulkAction'])->name('networks-list.bulk-action');
    //* all bulk action route end
});

//*user roles and permission
Route::group(['middleware' => ['auth']], function () {
    Route::prefix('admin')->group(function () {
        // Show users
        Route::resource('users', UserController::class);
        // Show roles
        Route::resource('roles', RoleController::class);
    });
});
//? admin panel end hare


//* Web pages route start
// Get Home page
Route::get('/', [HomeWebController::class, 'index'])->middleware('throttle:only_three_time');
// Get network page
Route::get('affiliate-network/{network_slug}', [NetworkWebController::class, 'index']);
// Get search network page
Route::get('/affiliate-networks', [SearchWebController::class, 'index']);
// Get resources page
Route::get('/resources', [ResourcesWebController::class, 'index']);
// Get reviews page
Route::get('/reviews', [ReviewsWebController::class, 'index']);
// Get offers page
Route::get('/offers', [OffersWebController::class, 'index']);
// Get blogs page
Route::get('/blogs', [BlogsWebController::class, 'index']);
// Get contact us page
Route::resource('/contact', ContactUsWebController::class);
// Get blogs view page
Route::get('blogsview/{slug}', [BlogsViewWebController::class, 'index']);
// Get network registration form / add network page
Route::resource('networks', NetworksController::class);
//Get network review form to create review on network page
Route::resource('review', NetworkReviewsWebController::class);

// // fetch data from offers API using controller
// Route::get('fetchdata', [OffersFetchController::class, 'store']);
// fetch offers data using command and jobs
Route::get('insertOffers', [OffersApi::class, 'handle']);
// get contact page
Route::get('/contactus', function () {
    return view('web.pages.contactus.contactus_index');
});

Route::get('/thankyou', function () {
    $web_logo = SystemSettingModel::all();
    return view('web.pages.common.thankyou', [
        'web_logo' => $web_logo
    ]);
});
//* Web pages route end


//? others functionality on Web pages, route start
//* review module 
//Get all review of one network on network page
Route::get('network/review/{network_id}', [NetworkReviewsWebController::class, 'get_network_review']);
// To verify review when user click on yes button in mail formate
Route::get('verifyreview/{token}', [NetworkReviewsWebController::class, 'verify_review']);
//To Reject review when user click on No button in mail formate
Route::get('rejectreview/{token}', [NetworkReviewsWebController::class, 'reject_review']);
//* review module end 

//*replies module 
// Submit reply form of review on network page
Route::resource('networkreply', ReplyWebController::class);
// Get all reply of one reviews on network page and review page using ajax
Route::get('review/replies/{parent_review_id}', [ReplyWebController::class, 'get_reply_Review']);
// Send email to verify replies when user click on yes button
Route::get('verifyreplies/{token}', [ReplyWebController::class, 'verify_replies']);
// Send email to verify replies when user click on no button
Route::get('rejectreplies/{token}', [ReplyWebController::class, 'reject_replies']);
//*replies module end 

//*login routes start
Route::prefix('admin')->group(function () {
    Route::get('dashboard', function () {
        return view('Admin.template');
    })->middleware(['auth', 'verified'])->name('admin.dashboard');
});

// // Custom login route
// Route::get('custom-login', [CustomLoginController::class, 'showLoginForm'])->name('custom.login');

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

//? others functionality on Web pages route end

//? testing purpose only
//* send email
// send again email to user after verify network
Route::get('afternetworkverify', [UserCreatedEmailController::class, 'after_network_verification']);
//verify email
Route::get('verifyemail', [UserCreatedEmailController::class, 'verify_email']);
//* send email end
