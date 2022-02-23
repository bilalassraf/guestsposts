<?php

namespace App\Providers;

use App\Models\AdvanceFilter;
use App\Models\Category;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use ConsoleTVs\Charts\Registrar as Charts;

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
        $filter = AdvanceFilter::first();
        view::share('filter',$filter);
        $categories = Category::all();
        view::share('categories',$categories);
    }
}
