<?php
namespace WebStream\Test\IntegrationTest\Controller;

use WebStream\Core\CoreController;
use WebStream\Module\Utility\CacheUtils;

class TestCacheController extends CoreController
{
    use CacheUtils;

    public function apcu()
    {
        $cache = $this->getCacheDriver("apcu", "test_cache");
        $cache->inject('logger', $this->logger);
        $this->print($cache);
    }

    public function memcached()
    {
        $cache = $this->getCacheDriver("memcached", "test_cache");
        $cache->inject('logger', $this->logger);
        $this->print($cache);
    }

    public function redis()
    {
        $cache = $this->getCacheDriver("redis", "test_cache");
        $cache->inject('logger', $this->logger);
        $this->print($cache);
    }

    public function temporaryfile()
    {
        $cache = $this->getCacheDriver("temporaryFile", "test_cache");
        $cache->inject('logger', $this->logger);
        $this->print($cache);
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
