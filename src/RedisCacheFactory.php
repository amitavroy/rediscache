<?php

namespace AmitavRoy\RedisCache;

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

    public function get($key)
    {
        $data = $this->redis
            ->pipeline()
            ->get($key)
            ->execute();

        return json_decode($data[0]);
    }

    public function set($key, $value)
    {
        $value = json_encode($value);

        $this->redis->pipeline()->set($key, $value)->execute();

        return $this->get($key);
    }

    public function getAll($key)
    {
        $keys = $this->redis->executeRaw(["KEYS", "{$key}*"]);

        $data = collect();

        foreach ($keys as $key) {
            $data->push([
                $key => $this->get($key)
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
