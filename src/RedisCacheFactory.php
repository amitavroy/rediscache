<?php

namespace AmitavRoy\RedisCache;

use Illuminate\Support\Collection;
use Predis\Client;

class RedisCacheFactory
{
    private $redis;

    /**
     * RedisCacheFactory constructor.
     */
    public function __construct()
    {
        $connections = config('rediscache.connections');

        $this->redis = new Client($connections[0]);
    }

    /**
     * This function is called through the Facades to retrive
     * data from the redis cache store. It internally uses
     * the pipeline mechanism to optimise the query to
     * redis and converts the data to send it back.
     */
    public function get($key)
    {
        $data = $this->redis
            ->pipeline()
            ->get($key)
            ->execute();

        $data = json_decode($data[0], true);

        /**
         * While setting the cache, if data was a collection
         * then we would like to return a collection when
         * we are passing it back from cache.
         */
        if (isset($data['collection']) && $data['collection'] == true) {
            $cacheData = collect($data['data']);
        } else {
            $cacheData = $data['data'];
        }

        return $cacheData;
    }

    public function set($key, $value)
    {
        $data = [
            'collection' => false,
            'data' => $value,
        ];

        if ($value instanceof Collection) {
            $data['collection'] = true;
        }

        $value = json_encode($data);

        $this->redis->pipeline()->set($key, $value)->execute();

        return $this->get($key);
    }

    public function getAll($key)
    {
        $keys = $this->redis->executeRaw(["KEYS", "{$key}*"]);

        $data = collect();

        foreach ($keys as $key) {
            $data->push([
                $key => $this->get($key),
            ]);
        }

        return $data;
    }

    public function forget($key, $wildcard = false)
    {
        if ($wildcard == true) {
            return $this->clearWildCard($key);
        }

        return $this->clearSingle($key);
    }

    private function clearSingle($key)
    {
        return $this->redis
            ->pipeline()
            ->del($key)
            ->execute();
    }

    private function clearWildCard($key)
    {
        $keys = $this->redis
            ->executeRaw(["KEYS", "{$key}*"]);

        if (count($keys) == 0) {
            return false;
        }

        return $this->redis
            ->pipeline()
            ->del($keys)
            ->execute();
    }
}
