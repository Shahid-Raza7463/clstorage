<?php

namespace App\Providers;

use App\Events\Admin\Adspaces\AdcreatedEvent;
use App\Events\Admin\Adspaces\AdexpiredEvent;
use App\Events\Admin\Adspaces\AdupdatedEvent;
use App\Events\Admin\FeaturedEvent;
use App\Events\Admin\LoginEvent;
use App\Events\Admin\LogoutEvent;
use App\Events\Admin\NetworkApprovedAdmin;
use App\Events\Admin\NetworkCreatedAdmin;
use App\Events\Admin\NetworkRejectedAdmin;
use App\Events\Admin\SearchEvent;
use App\Events\Admin\SponsoredEvent;
use App\Events\Admin\TopNetworkEvent;
use App\Events\Admin\UserCreatedAdmin;
use App\Events\NetworkCreated;
use App\Events\UserCreated;
use App\Events\AfterVerifyNetwork;
use App\Events\FeaturedUserEvent;
use App\Events\NetworkApproved;
use App\Events\NetworkPageVisiterEvent;
use App\Events\NetworkRejected;
use App\Events\Replies\RepliesCreatedAdmin;
use App\Events\Replies\RepliesCreatedNetwork;
use App\Events\Replies\RepliesVerifyUser;
use App\Events\Review\ReviewCreatedAdmin;
use App\Events\Review\ReviewCreatedNetwork;
use App\Events\Review\ReviewVerifyUser;
use App\Events\SponsoredUserEvent;
use App\Events\TopNetworkUserEvent;
use App\Events\VerifyEmailEvent;
use App\Listeners\Admin\Adspaces\AdcreatedNotification;
use App\Listeners\Admin\Adspaces\AdexpiredNotification;
use App\Listeners\Admin\Adspaces\AdupdatedNotification;
use App\Listeners\Admin\FeaturedNotification;
use App\Listeners\Admin\LoginNotification;
use App\Listeners\Admin\LogoutNotification;
use App\Listeners\Admin\NetworkApprovedAdminNotification;
use App\Listeners\Admin\NetworkApprovedRejectedNotification;
use App\Listeners\Admin\NetworkCreatedAdminNotification;
use App\Listeners\Admin\SponsoredNotification;
use App\Listeners\Admin\TopNetworkNotification;
use App\Listeners\Admin\UserCreatedAdminNotification;
use App\Listeners\AfterVerifyNetworkNotification;
use App\Listeners\FeaturedUserNotification;
use App\Listeners\NetworkApprovedNotifiation;
use App\Listeners\NetworkCreatedNotification;
use App\Listeners\NetworkPageVisiterNotification;
use App\Listeners\NetworkRejectedNotifiation;
use App\Listeners\Replies\RepliesCreatedAdminNotification;
use App\Listeners\Replies\RepliesCreatedNetworkNotification;
use App\Listeners\Replies\RepliesVerifyUserNotification;
use App\Listeners\Review\ReviewCreatedAdminNotification;
use App\Listeners\Review\ReviewCreatedNetworkNotification;
use App\Listeners\Review\ReviewVerifyUserNotification;
use App\Listeners\SearchNotification;
use App\Listeners\SponsoredUserNotification;
use App\Listeners\TopNetworkUserNotification;
use App\Listeners\UserCreatedNotification;
use App\Listeners\VerifyEmailNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        // get all mail regarding network registration process
        VerifyEmailEvent::class => [
            VerifyEmailNotification::class,
        ],
        NetworkCreated::class => [
            NetworkCreatedNotification::class,
        ],
        UserCreated::class => [
            UserCreatedNotification::class,
        ],
        AfterVerifyNetwork::class => [
            AfterVerifyNetworkNotification::class,
        ],
        NetworkApproved::class => [
            NetworkApprovedNotifiation::class,
        ],
        NetworkRejected::class => [
            NetworkRejectedNotifiation::class,
        ],
        UserCreatedAdmin::class => [
            UserCreatedAdminNotification::class,
        ],
        NetworkCreatedAdmin::class => [
            NetworkCreatedAdminNotification::class,
        ],
        NetworkApprovedAdmin::class => [
            NetworkApprovedAdminNotification::class,
        ],
        NetworkRejectedAdmin::class => [
            NetworkApprovedRejectedNotification::class,
        ],
        // review module
        ReviewVerifyUser::class => [
            ReviewVerifyUserNotification::class,
        ],

        ReviewCreatedAdmin::class => [
            ReviewCreatedAdminNotification::class,
        ],
        ReviewCreatedNetwork::class => [
            ReviewCreatedNetworkNotification::class,
        ],
        // reply module
        RepliesVerifyUser::class => [
            RepliesVerifyUserNotification::class,
        ],
        RepliesCreatedAdmin::class => [
            RepliesCreatedAdminNotification::class,
        ],
        RepliesCreatedNetwork::class => [
            RepliesCreatedNetworkNotification::class,
        ],
        // sponsored ,top network,featured email to admin
        FeaturedEvent::class => [
            FeaturedNotification::class,
        ],
        SponsoredEvent::class => [
            SponsoredNotification::class,
        ],
        TopNetworkEvent::class => [
            TopNetworkNotification::class,
        ],
        // sponsored ,top network,featured email to user
        FeaturedUserEvent::class => [
            FeaturedUserNotification::class,
        ],
        SponsoredUserEvent::class => [
            SponsoredUserNotification::class,
        ],
        TopNetworkUserEvent::class => [
            TopNetworkUserNotification::class,
        ],
        // adspaces event
        AdcreatedEvent::class => [
            AdcreatedNotification::class,
        ],
        AdupdatedEvent::class => [
            AdupdatedNotification::class,
        ],
        AdexpiredEvent::class => [
            AdexpiredNotification::class,
        ],
        // login and Logout 
        LoginEvent::class => [
            LoginNotification::class,
        ],
        LogoutEvent::class => [
            LogoutNotification::class,
        ],
        // pages Event
        NetworkPageVisiterEvent::class => [
            NetworkPageVisiterNotification::class,
        ],
        SearchEvent::class => [
            SearchNotification::class,
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
