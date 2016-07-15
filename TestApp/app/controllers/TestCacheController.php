<?php
namespace WebStream\Test\IntegrationTest\Controller;

use WebStream\Core\CoreController;
use WebStream\Cache\Driver\CacheDriverFactory;
use WebStream\Module\Container;

class TestCacheController extends CoreController
{
    public function apcu()
    {
        $factory = new CacheDriverFactory();
        $apcu = $factory->create("WebStream\Cache\Driver\Apcu");
        $apcu->inject('logger', $this->logger);
        $this->print($apcu);
    }

    public function memcached()
    {
        $factory = new CacheDriverFactory();
        $memcachedConfig = new Container(false);
        $memcachedConfig->servers = [
            ['memcached', 11211]
        ];
        $memcached = $factory->create("WebStream\Cache\Driver\Memcached", $memcachedConfig);
        $memcached->inject('logger', $this->logger);
        $this->print($memcached);
    }

    public function redis()
    {
        $factory = new CacheDriverFactory();
        $redisConfig = new Container(false);
        $redisConfig->host = "redis";
        $redisConfig->port = 6379;
        $redis = $factory->create("WebStream\Cache\Driver\Redis", $redisConfig);
        $redis->inject('logger', $this->logger);
        $this->print($redis);
    }

    private function print($cache)
    {
        $cache->add("key", 1, 0, false);
        echo $cache->get("key");
        $cache->add("key", 2, 0, true);
        echo $cache->get("key");
        $cache->add("key", "value1", 0, false);
        $cache->delete("key");
        echo $cache->get("key") === null;
        $cache->add("key1", "value1", 0, false);
        $cache->add("key2", "value2", 0, false);
        $cache->clear();
        echo $cache->get("key1") === null;
        echo $cache->get("key2") === null;
    }
}
