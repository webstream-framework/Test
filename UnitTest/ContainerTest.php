<?php
namespace WebStream\Test\UnitTest;

use WebStream\Module\Container;
use WebStream\Test\UnitTest\DataProvider\ContainerProvider;

require_once dirname(__FILE__) . '/TestBase.php';
require_once dirname(__FILE__) . '/DataProvider/ContainerProvider.php';

/**
 * ContainerTest
 * @author Ryuichi TANAKA.
 * @since 2016/05/29
 * @version 0.7
 */
class ContainerTest extends \PHPUnit_Framework_TestCase
{
    use ContainerProvider;

    /**
     * 正常系
     * プリミティブ型の値をコンテナにセットして取り出せること
     * @test
     * @dataProvider primitiveContainerProvider
     */
    public function okPrimitiveContainer($key, $value)
    {
        $container = new Container();
        $container->{$key} = $value;
        $this->assertEquals($value, $container->{$key});

        $container = new Container();
        $container->set($key, $value);
        $this->assertEquals($value, $container->get($key));

        $container = new Container();
        $container->register($key, $value);
        $this->assertEquals($value, $container->get($key));
    }

    /**
     * 正常系
     * クロージャ型の値をsetメソッド経由でコンテナにセットしたとき
     * クロージャ自体が取り出せること
     * @test
     * @dataProvider closureContainerProvider
     */
    public function okSetClosureBySetterContainer($key, $closure, $value)
    {
        $container = new Container();
        $container->set($key, $closure);
        $this->assertEquals($closure, $container->get($key));
    }

    /**
     * 正常系
     * クロージャ型の値をKey指定でコンテナにセットしたとき
     * クロージャの戻り値が取り出せること
     * @test
     * @dataProvider closureContainerProvider
     */
    public function okSetClosureByPropertyContainer($key, $closure, $value)
    {
        $container = new Container();
        $container->{$key} = $closure;
        $this->assertEquals($value, $container->{$key});
    }

    /**
     * 正常系
     * コンテナに格納した要素数を取得できること
     * @test
     */
    public function okContainerLength()
    {
        $container = new Container();
        $container->key1 = 1;
        $container->key2 = 2;
        $this->assertEquals($container->length(), 2);
    }

    /**
     * 正常系
     * コンテナに格納した値を削除できること
     * @test
     */
    public function okContainerRemove()
    {
        $container = new Container(false);
        $container->key1 = 1;
        $container->remove("key1");
        $this->assertNull($container->key1);
    }

    /**
     * 正常系
     * コンテナにセットしたクロージャが即時実行されること
     * @test
     */
    public function okRegisterDynamic()
    {
        $hoge = 0;
        $container = new Container();
        $closure = function() use (&$hoge) {
            $hoge = 1;
            return $hoge;
        };
        $container->registerAsDynamic("key", $closure);
        $this->assertEquals($hoge, 1);
        $this->assertEquals($container->key, 1);
    }

    /**
     * 正常系
     * コンテナにセットしたクロージャが遅延実行されること
     * @test
     */
    public function okRegisterLazy()
    {
        $hoge = 0;
        $container = new Container();
        $closure = function() use (&$hoge) {
            $hoge = 1;
            return $hoge;
        };
        $container->registerAsLazy("key", $closure);
        $this->assertEquals($hoge, 0);
        $this->assertEquals($container->key, 1);
    }

    /**
     * 正常系
     * コンテナにセットしたクロージャが遅延実行され、結果がキャッシュされること
     * @test
     */
    public function okRegisterLazyCache()
    {
        $hoge = 0;
        $container = new Container();
        $closure = function() use (&$hoge) {
            $hoge++;
            return $hoge;
        };
        $container->registerAsLazy("key", $closure);
        $this->assertEquals($hoge, 0);
        $this->assertEquals($container->key, 1);
        $this->assertEquals($container->key, 1);
    }

    /**
     * 正常系
     * コンテナにセットしたクロージャが遅延実行され、結果がキャッシュされないこと
     * @test
     */
    public function okRegisterLazyUnCached()
    {
        $hoge = 0;
        $container = new Container();
        $closure = function() use (&$hoge) {
            $hoge++;
            return $hoge;
        };
        $container->registerAsLazyUnCached("key", $closure);
        $this->assertEquals($hoge, 0);
        $this->assertEquals($container->key, 1);
        $this->assertEquals($container->key, 2);
    }

    /**
     * 正常系
     * コンテナを非strictで作成した場合、未定義の値を取り出すとnullが返ること
     * @test
     */
    public function okGetUnStrictContainer()
    {
        $container = new Container(false);
        $this->assertNull($container->undefined);
    }

    /**
     * 異常系
     * コンテナをstrictで作成した場合、未定義の値を取り出すと例外が発生すること
     * クロージャの戻り値が取り出せること
     * @test
     * @expectedException \WebStream\Exception\Extend\InvalidArgumentException
     */
    public function ngGetStrictContainer()
    {
        $container = new Container();
        $container->undefied;
    }
}
