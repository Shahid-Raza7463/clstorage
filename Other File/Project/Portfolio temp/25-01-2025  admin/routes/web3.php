<?php

use App\Http\Controllers\Admin\BlogsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\BlogsViewWebController;
use App\Http\Controllers\Web\BlogsWebController;
use App\Http\Controllers\Web\ContactUsWebController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\SkillsController;
use Illuminate\Support\Facades\Route;


//* admin panel
// Route::prefix('admin')->middleware('throttle:only_three_time')->group(function () {
//     Route::resource('blog', BlogsController::class);
//     Route::resource('users', UserController::class);
// });
//* admin panel
Route::prefix('admin')->middleware('throttle:only_three_time')->group(function () {
    // Preference tab
    // Route::resource('commissiontype', CommissionTypesController::class);
    // Route::resource('networksoftware', NetworkSoftwaresController::class);
    // Route::resource('paymentfrequency', PaymentsFrequencyController::class);
    // Route::resource('paymentmethod', PaymentMethodsController::class);
    // Route::resource('verticals', VerticalController::class);
    // //networks tab
    // Route::resource('networks-list', NetworkRegisterController::class);
    // Route::get('sponsored', [NetworkRegisterController::class, 'all_sponsored_networks']);
    // Route::get('top-networks', [NetworkRegisterController::class, 'all_top_networks']);
    // Route::get('featured-networks', [NetworkRegisterController::class, 'featured_networks']);
    // //all ads route
    // Route::resource('adspaces', AdspacesController::class);
    // Route::get('network-ads', [AdspacesController::class, 'get_networkofthemonths_ads']);
    // Route::get('carousel-ads', [AdspacesController::class, 'home_page_carousel_ads']);
    // Route::get('inpage-ads', [AdspacesController::class, 'in_page_ads']);
    // Route::get('sponsored-ads', [AdspacesController::class, 'sponsored_ads']);
    // Route::get('sponsored-small', [AdspacesController::class, 'sponsored_small']);
    // Route::get('featured-ads', [AdspacesController::class, 'featured_ads']);
    // //all ads route end
    // Route::resource('reviewslist', ReviewsController::class);
    // Route::resource('resourcelist', ResourcesController::class);
    // Route::resource('systemsettings', SystemSettingsController::class);
    // Route::resource('seo-meta', SeoMetaController::class);
    // Route::resource('blog', BlogsController::class);
    // Route::resource('contact-us', ContactUsController::class);
    // // Offers tab
    // Route::resource('offers', OfferController::class);
    // Route::get('latest-offers', [OfferController::class, 'get_latest_offers']);
    // Route::get('top-offers', [OfferController::class, 'get_top_offers']);
    // Route::get('featured-offers', [OfferController::class, 'get_featured_offers']);
    // Route::resource('offers-api', OffersApiController::class);
    // // Get bulk action
    // Route::post('commissiontype/bulk-action', [CommissionTypesController::class, 'bulkAction'])->name('commissiontype.bulk-action');
    // Route::post('networksoftware/bulk-action', [NetworkSoftwaresController::class, 'bulkAction'])->name('networksoftware.bulk-action');
    // Route::post('paymentfrequency/bulk-action', [PaymentsFrequencyController::class, 'bulkAction'])->name('paymentfrequency.bulk-action');
    // Route::post('paymentmethod/bulk-action', [PaymentMethodsController::class, 'bulkAction'])->name('paymentmethod.bulk-action');
    // Route::post('verticals/bulk-action', [VerticalController::class, 'bulkAction'])->name('verticals.bulk-action');
    // Route::post('offers-api/bulk-action', [OffersApiController::class, 'bulkAction'])->name('offers-api.bulk-action');
    Route::post('users/bulk-action', [UserController::class, 'bulkAction'])->name('users.bulk-action');
    // Route::post('roles/bulk-action', [RoleController::class, 'bulkAction'])->name('roles.bulk-action');
    // Route::post('systemsettings/bulk-action', [SystemSettingsController::class, 'bulkAction'])->name('systemsettings.bulk-action');
    // Route::post('seo-meta/bulk-action', [SeoMetaController::class, 'bulkAction'])->name('seo-meta.bulk-action');
    // Route::post('contact-us/bulk-action', [ContactUsController::class, 'bulkAction'])->name('contact-us.bulk-action');
    // Route::post('blog/bulk-action', [BlogsController::class, 'bulkAction'])->name('blog.bulk-action');
    // Route::post('reviewslist/bulk-action', [ReviewsController::class, 'bulkAction'])->name('reviewslist.bulk-action');
    // Route::post('resourcelist/bulk-action', [ResourcesController::class, 'bulkAction'])->name('resourcelist.bulk-action');
    // Route::post('adspaces/bulk-action', [AdspacesController::class, 'bulkAction'])->name('adspaces.bulk-action');
    // Route::post('offers/bulk-action', [OfferController::class, 'bulkAction'])->name('offers.bulk-action');
    // Route::post('networks-list/bulk-action', [NetworkRegisterController::class, 'bulkAction'])->name('networks-list.bulk-action');
});

// user roles and permission
Route::group(['middleware' => ['auth']], function () {
    Route::prefix('admin')->group(function () {
        Route::resource('users', UserController::class);
        // Route::resource('roles', RoleController::class);
        // Route::resource('products', ProductController::class);
    });
});
//* admin panel end hare

// Web
// Route::get('/', [BlogsWebController::class, 'index']);
Route::get('blogsview/{slug}', [BlogsViewWebController::class, 'index']);

//*login routes start
Route::prefix('admin')->group(function () {
    Route::get('dashboard', function () {
        return view('Admin.template');
    })->middleware(['auth', 'verified'])->name('admin.dashboard');
});

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

//* portfolio start
// page all 
// Route::get('/portfolio-details', function () {
//     return view('web.pages.portfolio-details');
// });

// Route::get('/index-page', function () {
//     return view('web.pages.index');
// });

// Route::get('/service-details', function () {
//     return view('web.pages.service-details');
// });

// Route::get('/starter-page', function () {
//     return view('web.pages.starter-page');
// });


// Route::get('/',  function () {
//     return view('web.pages.home.index');
// });
// Route::get('/portfolio-details/{id}', function ($id) {
//     if ($id == 1) {
//         return view('web.pages.portfolio.portfolio');
//     } else {
//         return view('web.pages.portfolio.portfolio2');
//     }
// });


//* All portfolio
Route::get('/portfolio-details/1', function () {
    return view('web.pages.portfolio.project1.portfolio');
});
Route::get('/portfolio-details/2', function () {
    return view('web.pages.portfolio.project2.portfolio');
});
Route::get('/portfolio-details/3', function () {
    return view('web.pages.portfolio.project3.portfolio');
});
Route::get('/portfolio-details/4', function () {
    return view('web.pages.portfolio.project4.portfolio');
});
Route::get('/portfolio-details/5', function () {
    return view('web.pages.portfolio.project5.portfolio');
});
Route::get('/portfolio-details/6', function () {
    return view('web.pages.portfolio.project6.portfolio');
});
Route::get('/portfolio-details/7', function () {
    return view('web.pages.portfolio.project7.portfolio');
});
Route::get('/portfolio-details/8', function () {
    return view('web.pages.portfolio.project8.portfolio');
});
Route::get('/portfolio-details/9', function () {
    return view('web.pages.portfolio.project9.portfolio');
});
Route::get('/portfolio-details/10', function () {
    return view('web.pages.portfolio.project10.portfolio');
});

//? All android portfolio start hare 
Route::get('/android-app/4', function () {
    return view('web.pages.portfolio.androidapp4.androidapp');
});
Route::get('/android-app/3', function () {
    return view('web.pages.portfolio.androidapp3.androidapp');
});
Route::get('/android-app/2', function () {
    return view('web.pages.portfolio.androidapp2.androidapp');
});
Route::get('/android-app/1', function () {
    return view('web.pages.portfolio.androidapp1.androidapp');
});

//* All portfolio end hare 

Route::resource('/contact', ContactUsWebController::class);
Route::get('img/{name}', [ContactUsWebController::class, 'download']);

Route::resource('/skills', SkillsController::class);
Route::resource('/', HomeController::class);


// All portfolio end 

Route::get('/service-details', function () {
    return view('web.pages.service.service');
});

Route::get('/starter-page', function () {
    return view('web.pages.starter.starter');
});

//* start end
