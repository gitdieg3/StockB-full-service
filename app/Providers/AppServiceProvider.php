<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Barang;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
{
    View::composer('*', function ($view) {
        $stokHampirHabisCount = Barang::where('jumlah', '<=', 5)->count();
        $stokHampirHabisList = Barang::where('jumlah', '<=', 5)->get();

        $view->with('stokHampirHabisCount', $stokHampirHabisCount);
        $view->with('stokHampirHabisList', $stokHampirHabisList);
    });
}
}
