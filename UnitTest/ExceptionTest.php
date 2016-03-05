<?php
namespace WebStream\Test\UnitTest;

use WebStream\Module\Container;
use WebStream\Module\Utility\LoggerUtils;
use WebStream\Log\Logger;
use WebStream\Log\Outputter\ConsoleOutputter;
use WebStream\Exception\DelegateException;
use WebStream\Exception\Extend\ClassNotFoundException;
use WebStream\Test\UnitTest\DataProvider\ExceptionProvider;

require_once dirname(__FILE__) . '/TestBase.php';
require_once dirname(__FILE__) . '/DataProvider/ExceptionProvider.php';

/**
 * ExceptionTest
 * @author Ryuichi TANAKA.
 * @since 2016/03/05
 * @version 0.7
 */
class ExceptionTest extends \PHPUnit_Framework_TestCase
{
    use LoggerUtils, ExceptionProvider;

    public function setUp()
    {
        $config = new Container(false);
        $config->logPath = "";
        $config->statusPath = "";
        $config->logLevel = $this->toLogLevelValue("debug");
        $config->format = "%m";
        Logger::init($config);
        Logger::getInstance()->setOutputter([new ConsoleOutputter()]);
    }

    public function tearDown()
    {
        Logger::finalize();
    }

    /**
     * 正常系
     * 例外が実行されること
     * ログメッセージにログ情報が出力されること
     * @test
     * @dataProvider exceptionProvider
     */
    public function okException($exceptionClass)
    {
        ob_start();
        $classpath = "";
        try {
            throw new $exceptionClass("owata");
        } catch (\Exception $e) {
            $classpath = get_class($e);
        }
        $this->assertStringStartsWith("$classpath is thrown", ob_get_clean());
    }

    /**
     * 正常系
     * ClassNotFoundExceptionの任意のメソッドにアクセスすると例外が発生すること
     * @test
     */
    public function okClassNotFoundException()
    {
        ob_start();
        $classpath = "";
        try {
            $exception = new ClassNotFoundException();
            $exception->hoge();
        } catch (\Exception $e) {
            $classpath = get_class($e);
        }
        $this->assertStringStartsWith("$classpath is thrown", ob_get_clean());
    }

    /**
     * 正常系
     * DelegateExceptionにより例外を持ち回れること
     * @test
     */
    public function okDelegateException()
    {
        $exception = new \Exception("exception");
        $delegateException = new DelegateException($exception);
        $this->assertInstanceOf("\Exception", $delegateException->getOriginException());
        ob_clean();
    }
}
