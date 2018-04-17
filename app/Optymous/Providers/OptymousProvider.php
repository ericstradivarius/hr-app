<?php

namespace App\Optymous\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Optymous\Exceptions\Handler;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;

class OptymousProvider extends ServiceProvider {
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        Schema::defaultStringLength(191);
        $this->loadMigrationsFrom(base_path('app/Optymous/database/migrations'));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        $this->app->bind('Illuminate\Contracts\Debug\ExceptionHandler', function ($app) {
            return new Handler($app);
        });

        $this->registerEloquentFactoriesFrom(base_path('app/Optymous/database/factories'));
    }

    protected function registerEloquentFactoriesFrom($path) {
        $this->app->make(EloquentFactory::class)->load($path);
    }
}
