<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\Company;
use App\Models\Image;
use App\Models\Proposal;
use App\Models\Setting;
use App\Models\User;
use App\Observers\ClientObserver;
use App\Observers\CompanyObserver;
use App\Observers\ImageObserver;
use App\Observers\ProposalObserver;
use App\Observers\SettingObserver;
use App\Observers\UserObserver;
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
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Client::observe(ClientObserver::class);
        Proposal::observe(ProposalObserver::class);
        User::observe(UserObserver::class);
        Image::observe(ImageObserver::class);
        Company::observe(CompanyObserver::class);
        Setting::observe(SettingObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
