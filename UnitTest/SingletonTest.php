<?php
namespace WebStream\Test\UnitTest;

use WebStream\Module\Singleton;

require_once dirname(__FILE__) . '/TestBase.php';
class SingletonClass { use Singleton; }

/**
 * SingletonTest
 * @author Ryuichi TANAKA.
 * @since 2016/05/29
 * @version 0.7
 */
class SingletonTest extends \PHPUnit_Framework_TestCase
{
    /**
     * 正常系
     * 常に同じオブジェクトしか返却されないこと
     * @test
     */
    public function okCreateSingletonObject()
    {
        $this->assertEquals(spl_object_hash(SingletonClass::getInstance()), spl_object_hash(SingletonClass::getInstance()));
    }

    /**
     * 異常系
     * Singletonオブジェクトをクローンすると例外が発生すること
     * @test
     * @expectedException \RuntimeException
     */
    public function ngCloneSingletonObject()
    {
        $obj = SingletonClass::getInstance();
        clone $obj;
    }
}
