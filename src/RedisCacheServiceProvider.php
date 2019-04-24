<?php

namespace AmitavRoy\RedisCache;

use Illuminate\Support\ServiceProvider;

class RedisCacheServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/publishes/config/rediscache.php' => config_path('rediscache.php'),
        ]);
    }

    public function register()
    {
        $this->app->bind('redis-cache', function () {
            return new RedisCacheFactory;
        });
    }
}
