<?php

namespace App\Providers;

use App\Lib\Cachable\Repository;
use App\Lib\Vk\Vk;
use App\Models\Repositories\User;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
        $this->app->singleton('CachableRepository', Repository::class);
        $this->app->singleton('UserRepository', User::class);
    }
}
