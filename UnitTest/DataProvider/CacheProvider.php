<?php
namespace WebStream\Test\UnitTest\DataProvider;

use WebStream\Module\Container;
use WebStream\Cache\Driver\Apcu;
use WebStream\Cache\Driver\Memcached;
use WebStream\Cache\Driver\Redis;

/**
 * CacheProvider
 * @author Ryuichi TANAKA.
 * @since 2016/07/11
 * @version 0.7
 */
trait CacheProvider
{
    public function cacheMockProvider()
    {
        return [
            [$this->getApcuMockObject()],
            [$this->getMemcachedMockObject()],
            [$this->getRedisMockObject()]
        ];
    }

    private function getApcuMockObject()
    {
        $apcuContainer = new Container();
        $apcuContainer->available = true;
        $apcuContainer->cachePrefix = "cache.apcu.";
        $apcuContainer->driver = new class()
        {
            private $expect;

            public function delegate($function, array $args = [])
            {
                $result = null;
                switch ($function) {
                    case "apcu_store":
                    case "apcu_add":
                        $this->expect = "value1";
                        $result = true;
                        break;
                    case "apcu_delete":
                    case "apcu_clear_cache":
                        $this->expect = null;
                        $result = true;
                        break;
                    case "apcu_fetch":
                        $result = $this->expect;
                        break;
                }

                return $result;
            }
        };

        $logger = new class() { function __call($name, $args) {} };
        $apcu = new Apcu($apcuContainer);
        $apcu->inject('logger', $logger);

        return $apcu;
    }

    private function getMemcachedMockObject()
    {
        $memcachedContainer = new Container();
        $memcachedContainer->available = true;
        $memcachedContainer->cachePrefix = "cache.memcached.";
        $memcachedContainer->codes = ["success" => 1, "notfound" => 1];
        $memcachedContainer->driver = new class()
        {
            private $expect;

            public function __call($method, $args)
            {
                $result = null;
                switch ($method) {
                    case "replace":
                    case "set":
                        $this->expect = "value1";
                        $result = true;
                        break;
                    case "delete":
                    case "flush":
                    case "deleteMulti":
                        $this->expect = null;
                        $result = true;
                        break;
                    case "getAllKeys":
                        $result = [];
                        break;
                    case "get":
                        $result = $this->expect;
                        break;
                    case "getResultCode":
                        $result = 1;
                        break;
                }

                return $result;
            }
        };

        $logger = new class() { function __call($name, $args) {} };
        $memcached = new Memcached($memcachedContainer);
        $memcached->inject('logger', $logger);

        return $memcached;
    }

    private function getRedisMockObject()
    {
        $redisContainer = new Container();
        $redisContainer->available = true;
        $redisContainer->cachePrefix = "cache.redis.";
        $redisContainer->redisOptPrefix = 2;

        $redisContainer->driver = new class()
        {
            private $expect;
            private $scanList;

            public function __construct()
            {
                $this->scanList = [1];
            }

            public function __call($method, $args)
            {
                $result = null;
                switch ($method) {
                    case "set":
                    case "setEx":
                    case "setNx":
                        $this->expect = "value1";
                        $result = true;
                        break;
                    case "delete":
                        $this->expect = null;
                        $result = 1;
                        break;
                    case "scan":
                        if (count($this->scanList) > 0) {
                            $result = array_pop($this->scanList);
                        } else {
                            $result = null;
                        }
                        break;
                    case "get":
                        $result = $this->expect;
                        break;
                }

                return $result;
            }
        };

        $logger = new class() { function __call($name, $args) {} };
        $redis = new Redis($redisContainer);
        $redis->inject('logger', $logger);

        return $redis;
    }
}
