<?php
namespace WebStream\Test\IntegrationTest\DataProvider;

use WebStream\Module\Container;
use WebStream\Cache\Driver\CacheDriverFactory;

/**
 * MiddlewareProvider
 * @author Ryuichi TANAKA.
 * @since 2016/07/11
 * @version 0.7
 */
trait MiddlewareProvider
{
    public function cacheConfigProvider()
    {
        $factory = new CacheDriverFactory();
        $memcachedConfig = new Container(false);
        $memcachedConfig->servers = [
            ['127.0.0.1', 11211]
        ];

        $redisConfig = new Container(false);
        $redisConfig->host = "127.0.0.1";
        $redisConfig->port = 6379;

        $logger = new class() { function __call($name, $args) {} };
        $apcu = $factory->create("WebStream\Cache\Driver\Apcu");
        $apcu->inject('logger', $logger);
        $memcached = $factory->create("WebStream\Cache\Driver\Memcached", $memcachedConfig);
        $memcached->inject('logger', $logger);
        $redis = $factory->create("WebStream\Cache\Driver\Redis", $redisConfig);
        $redis->inject('logger', $logger);

        echo get_class($memcached);

        return [
            [$apcu],
            [$memcached],
            [$redis]
        ];
    }
}
