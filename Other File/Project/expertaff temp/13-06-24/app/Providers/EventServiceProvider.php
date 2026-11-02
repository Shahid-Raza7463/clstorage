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
        //? get all mail regarding network registration process.
        // send to User,VerifyEmailEvent event
        VerifyEmailEvent::class => [
            VerifyEmailNotification::class,
        ],
        // send to User,NetworkCreated event
        NetworkCreated::class => [
            NetworkCreatedNotification::class,
        ],
        // send to User,UserCreated event
        UserCreated::class => [
            UserCreatedNotification::class,
        ],
        // send to User,AfterVerifyNetwork event
        AfterVerifyNetwork::class => [
            AfterVerifyNetworkNotification::class,
        ],
        // send to User,NetworkApproved event
        NetworkApproved::class => [
            NetworkApprovedNotifiation::class,
        ],
        // send to User,NetworkRejected event
        NetworkRejected::class => [
            NetworkRejectedNotifiation::class,
        ],
        // send to Admin,UserCreatedAdmin event
        UserCreatedAdmin::class => [
            UserCreatedAdminNotification::class,
        ],
        // send to Admin,NetworkCreatedAdmin event
        NetworkCreatedAdmin::class => [
            NetworkCreatedAdminNotification::class,
        ],
        // send to Admin,NetworkApprovedAdmin event
        NetworkApprovedAdmin::class => [
            NetworkApprovedAdminNotification::class,
        ],
        // send to Admin,NetworkRejectedAdmin event
        NetworkRejectedAdmin::class => [
            NetworkApprovedRejectedNotification::class,
        ],
        //? review module
        // send to User,ReviewVerifyUser event
        ReviewVerifyUser::class => [
            ReviewVerifyUserNotification::class,
        ],
        // send to Admin,ReviewCreatedAdmin event
        ReviewCreatedAdmin::class => [
            ReviewCreatedAdminNotification::class,
        ],
        // send to network owner,ReviewCreatedNetwork event
        ReviewCreatedNetwork::class => [
            ReviewCreatedNetworkNotification::class,
        ],
        //? reply module
        // send to User,RepliesVerifyUser event
        RepliesVerifyUser::class => [
            RepliesVerifyUserNotification::class,
        ],
        // send to Admin,RepliesCreatedAdmin event
        RepliesCreatedAdmin::class => [
            RepliesCreatedAdminNotification::class,
        ],
        // send to network owner,RepliesCreatedNetwork event
        RepliesCreatedNetwork::class => [
            RepliesCreatedNetworkNotification::class,
        ],
        //? sponsored ,top network,featured email to admin
        // send to Admin,FeaturedEvent event
        FeaturedEvent::class => [
            FeaturedNotification::class,
        ],
        // send to Admin,SponsoredEvent event
        SponsoredEvent::class => [
            SponsoredNotification::class,
        ],
        // send to Admin,TopNetworkEvent event
        TopNetworkEvent::class => [
            TopNetworkNotification::class,
        ],
        //? sponsored ,top network,featured email to user
        // send to User,FeaturedUserEvent event
        FeaturedUserEvent::class => [
            FeaturedUserNotification::class,
        ],
        // send to User,SponsoredUserEvent event
        SponsoredUserEvent::class => [
            SponsoredUserNotification::class,
        ],
        // send to User,TopNetworkUserEvent event
        TopNetworkUserEvent::class => [
            TopNetworkUserNotification::class,
        ],
        //? adspaces event
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
