<?php
namespace WebStream\Test\UnitTest;

use WebStream\Test\UnitTest\DataProvider\CacheProvider;

require_once dirname(__FILE__) . '/TestBase.php';
require_once dirname(__FILE__) . '/DataProvider/CacheProvider.php';

/**
 * CacheTest
 * @author Ryuichi TANAKA.
 * @since 2016/07/06
 * @version 0.7
 */
class CacheTest extends \PHPUnit_Framework_TestCase
{
    use CacheProvider;

    /**
     * 正常系
     * キャッシュを新規追加できること
     * @test
     * @dataProvider cacheMockProvider
     */
    public function okAddCache($cache)
    {
        $cache->add("key", "value1", 0, false);
        $this->assertEquals($cache->get("key"), "value1");
    }

    /**
     * 正常系
     * キャッシュを上書きできること
     * @test
     * @dataProvider cacheMockProvider
     */
    public function okAddOverwriteCache($cache)
    {
        $cache->add("key", "value1", 0, true);
        $this->assertEquals($cache->get("key"), "value1");
    }

    /**
     * 正常系
     * キャッシュを削除できること
     * @test
     * @dataProvider cacheMockProvider
     */
    public function okDeleteCache($cache)
    {
        $cache->add("key", "value1", 0, true);
        $cache->delete("key");
        $this->assertNull($cache->get("key"));
    }

    /**
     * 正常系
     * キャッシュを削除できること
     * @test
     * @dataProvider cacheMockProvider
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
