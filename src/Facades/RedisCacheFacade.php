<?php

namespace AmitavRoy\RedisCache\Facades;

use Illuminate\Support\Facades\Facade;

class RedisCacheFacade extends Facade
{
    protected static function getFacadeAccessor() {
        return 'redis-cache';
    }
}
