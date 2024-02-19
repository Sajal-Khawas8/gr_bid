<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Category;
use App\Models\Event;
use App\Models\Inventory;
use App\Models\Location;
use App\Models\User;
use App\Policies\CategoryPolicy;
use App\Policies\EventPolicy;
use App\Policies\InventoryPolicy;
use App\Policies\LocationPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Event::class => EventPolicy::class,
        Inventory::class => InventoryPolicy::class,
        Category::class => CategoryPolicy::class,
        Location::class => LocationPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
