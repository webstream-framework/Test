<?php
namespace WebStream\Test\IntegrationTest;

use WebStream\Test\IntegrationTest\DataProvider\MiddlewareProvider;

require_once dirname(__FILE__) . '/TestBase.php';
require_once dirname(__FILE__) . '/DataProvider/MiddlewareProvider.php';

/**
 * MiddlewareTest
 * @author Ryuichi TANAKA.
 * @since 2016/07/11
 * @version 0.7
 */
class MiddlewareTest extends \PHPUnit_Framework_TestCase
{
    use MiddlewareProvider;

    /**
     * 正常系
     * 外部キャッシュライブラリを使用してキャッシュを追加できること
     * @test
     * @dataProvider cacheConfigProvider
     */
    public function okAddCache($cache)
    {
        $cache->add("key", "value1", 0, true);
        $this->assertEquals($cache->get("key"), "value1");
    }

    /**
     * 正常系
     * 外部キャッシュライブラリを使用してキャッシュを削除できること
     * @test
     * @dataProvider cacheConfigProvider
     */
    public function okDeleteCache($cache)
    {
        $cache->add("key", "value1", 0, true);
        $cache->delete("key");
        $this->assertNull($cache->get("key"));
    }

    /**
     * 正常系
     * 外部キャッシュライブラリを使用してキャッシュをすべて削除できること
     * @test
     * @dataProvider cacheConfigProvider
     */
    public function okClearCache($cache)
    {
        $cache->add("key1", "value1", 0, true);
        $cache->add("key2", "value2", 0, true);
        $cache->clear();
        $this->assertNull($cache->get("key1"));
        $this->assertNull($cache->get("key2"));
    }
}
