<?php

namespace App\Providers;

use App\Project;
use App\Observers\ProjectObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

use Queue;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Project::observe(ProjectObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        

    }
}
