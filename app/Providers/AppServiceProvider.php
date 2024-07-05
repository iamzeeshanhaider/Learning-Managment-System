<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Payment;
use App\Models\Ticket;
use App\Observers\CategoryObserver;
use App\Observers\PaymentObserver;
use App\Observers\TicketObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        Category::observe(CategoryObserver::class);
        Payment::observe(PaymentObserver::class);
        Ticket::observe(TicketObserver::class);
    }
}
