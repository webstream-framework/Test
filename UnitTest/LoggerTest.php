<?php
namespace WebStream\Test\UnitTest;

use WebStream\Log\Logger;
use WebStream\Log\LoggerAdapter;
use WebStream\Log\Outputter\ConsoleOutputter;
use WebStream\Module\Container;
use WebStream\Module\Utility\LoggerUtils;
use WebStream\Test\UnitTest\DataProvider\LoggerProvider;

require_once dirname(__FILE__) . '/TestBase.php';
require_once dirname(__FILE__) . '/DataProvider/LoggerProvider.php';

/**
 * LoggerTest
 * @author Ryuichi TANAKA.
 * @since 2016/01/30
 * @version 0.7
 */
class LoggerTest extends \PHPUnit_Framework_TestCase
{
    use LoggerProvider, LoggerUtils;

    public function tearDown()
    {
        Logger::finalize();
    }

    private function getLogger(Container $config)
    {
        Logger::init($config);
        $instance = Logger::getInstance();
        $instance->setOutputter([new ConsoleOutputter()]);

        return new LoggerAdapter($instance);
    }

    private function getRotatableLogger(Container $container)
    {
        Logger::init($config);
        $instance = Logger::getInstance();
        $instance->setOutputter([new ConsoleOutputter()]);

        return new LoggerAdapter($instance);
    }

    private function assertLog($level, $msg, $logLine)
    {
        if (preg_match('/^\[\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}:\d{2}\..{3}\]\[(.+?)\]\s(.*)$/', $logLine, $matches)) {
            $target = [$level, $msg];
            $result = [trim($matches[1]), $matches[2]];
            $this->assertEquals($target, $result);
        } else {
            $this->assertTrue(false);
        }
    }

    /**
     * 正常系
     * LoggerAdapter経由でログが書き込めること
     * @test
     * @dataProvider loggerAdapterProvider
     */
    public function okLoggerAdapter($level)
    {
        $msg = "log message";
        $config = new Container(false);
        $config->logLevel = $this->toLogLevelValue($level);
        $config->format = "[%d{%Y-%m-%d %H:%M:%S.%f}][%5L] %m";
        $logger = $this->getLogger($config);

        ob_start();
        $logger->{$level}($msg);
        $actual = ob_get_clean();

        $this->assertLog(strtoupper($level), $msg, $actual);
    }

    /**
     * 正常系
     * LoggerAdapter経由でログが書き込めること、プレースホルダーで値を埋め込めること
     * @test
     * @dataProvider loggerAdapterWithPlaceholderProvider
     */
    public function okLoggerAdapterWithPlaceholder($level, $msg1, $msg2, array $placeholder)
    {
        $config = new Container(false);
        $config->logLevel = $this->toLogLevelValue($level);
        $config->format = "[%d{%Y-%m-%d %H:%M:%S.%f}][%5L] %m";
        $logger = $this->getLogger($config);

        ob_start();
        $logger->{$level}($msg2, $placeholder);
        $actual = ob_get_clean();

        $this->assertLog(strtoupper($level), $msg1, $actual);
    }

    /**
     * 正常系
     * ログレベルが「debug」のとき、
     * 「debug」「info」「notice」「warn」「warning」「error」「critical」「alert」「emergency」「fatal」レベルのログが書き出せること
     * @test
     * @dataProvider logLevelDebugProvider
     */
    public function okWriteDebug($logLevel, $isWrite)
    {
        $msg = "log message";
        $execLevel = "debug";

        $config = new Container(false);
        $config->logLevel = $this->toLogLevelValue($execLevel);
        $config->format = "%m";
        $logger = $this->getLogger($config);

        ob_start();
        $logger->{$logLevel}($msg);
        $actual = ob_get_clean();

        $this->assertEquals($isWrite, trim($actual) === $msg);
    }

    /**
     * 正常系
     * ログレベルが「info」のとき、
     * 「info」「notice」「warn」「warning」「error」「critical」「alert」「emergency」「fatal」レベルのログが書き出せること
     * @test
     * @dataProvider logLevelInfoProvider
     */
    public function okWriteInfo($logLevel, $isWrite)
    {
        $msg = "log message";
        $execLevel = "info";

        $config = new Container(false);
        $config->logLevel = $this->toLogLevelValue($execLevel);
        $config->format = "%m";
        $logger = $this->getLogger($config);

        ob_start();
        $logger->{$logLevel}($msg);
        $actual = ob_get_clean();

        $this->assertEquals($isWrite, trim($actual) === $msg);
    }

    /**
     * 正常系
     * ログレベルが「notice」のとき、
     * 「notice」「warn」「warning」「error」「critical」「alert」「emergency」「fatal」レベルのログが書き出せること
     * @test
     * @dataProvider logLevelNoticeProvider
     */
    public function okWriteNotice($logLevel, $isWrite)
    {
        $msg = "log message";
        $execLevel = "notice";

        $config = new Container(false);
        $config->logLevel = $this->toLogLevelValue($execLevel);
        $config->format = "%m";
        $logger = $this->getLogger($config);

        ob_start();
        $logger->{$logLevel}($msg);
        $actual = ob_get_clean();

        $this->assertEquals($isWrite, trim($actual) === $msg);
    }

    /**
     * 正常系
     * ログレベルが「warn」のとき、
     * 「warn」「warning」「error」「critical」「alert」「emergency」「fatal」レベルのログが書き出せること
     * @test
     * @dataProvider logLevelWarnProvider
     */
    public function okWriteWarn($logLevel, $isWrite)
    {
        $msg = "log message";
        $execLevel = "warn";

        $config = new Container(false);
        $config->logLevel = $this->toLogLevelValue($execLevel);
        $config->format = "%m";
        $logger = $this->getLogger($config);

        ob_start();
        $logger->{$logLevel}($msg);
        $actual = ob_get_clean();

        $this->assertEquals($isWrite, trim($actual) === $msg);
    }

    /**
     * 正常系
     * ログレベルが「warning」のとき、
     * 「warn」「warning」「error」「critical」「alert」「emergency」「fatal」レベルのログが書き出せること
     * @test
     * @dataProvider logLevelWarningProvider
     */
    public function okWriteWarning($logLevel, $isWrite)
    {
        $msg = "log message";
        $execLevel = "warning";

        $config = new Container(false);
        $config->logLevel = $this->toLogLevelValue($execLevel);
        $config->format = "%m";
        $logger = $this->getLogger($config);

        ob_start();
        $logger->{$logLevel}($msg);
        $actual = ob_get_clean();

        $this->assertEquals($isWrite, trim($actual) === $msg);
    }

    /**
     * 正常系
     * ログレベルが「error」のとき、
     * 「error」「critical」「alert」「emergency」「fatal」レベルのログが書き出せること
     * @test
     * @dataProvider logLevelErrorProvider
     */
    public function okWriteError($logLevel, $isWrite)
    {
        $msg = "log message";
        $execLevel = "error";

        $config = new Container(false);
        $config->logLevel = $this->toLogLevelValue($execLevel);
        $config->format = "%m";
        $logger = $this->getLogger($config);

        ob_start();
        $logger->{$logLevel}($msg);
        $actual = ob_get_clean();

        $this->assertEquals($isWrite, trim($actual) === $msg);
    }

    /**
     * 正常系
     * ログレベルが「critical」のとき、
     * 「critical」「alert」「emergency」「fatal」レベルのログが書き出せること
     * @test
     * @dataProvider logLevelCriticalProvider
     */
    public function okWriteCritical($logLevel, $isWrite)
    {
        $msg = "log message";
        $execLevel = "critical";

        $config = new Container(false);
        $config->logLevel = $this->toLogLevelValue($execLevel);
        $config->format = "%m";
        $logger = $this->getLogger($config);

        ob_start();
        $logger->{$logLevel}($msg);
        $actual = ob_get_clean();

        $this->assertEquals($isWrite, trim($actual) === $msg);
    }

    /**
     * 正常系
     * ログレベルが「alert」のとき、
     * 「alert」「emergency」「fatal」レベルのログが書き出せること
     * @test
     * @dataProvider logLevelAlertProvider
     */
    public function okWriteAlert($logLevel, $isWrite)
    {
        $msg = "log message";
        $execLevel = "alert";

        $config = new Container(false);
        $config->logLevel = $this->toLogLevelValue($execLevel);
        $config->format = "%m";
        $logger = $this->getLogger($config);

        ob_start();
        $logger->{$logLevel}($msg);
        $actual = ob_get_clean();

        $this->assertEquals($isWrite, trim($actual) === $msg);
    }

    /**
     * 正常系
     * ログレベルが「emergency」のとき、
     * 「emergency」「fatal」レベルのログが書き出せること
     * @test
     * @dataProvider logLevelEmergencyProvider
     */
    public function okWriteEmergency($logLevel, $isWrite)
    {
        $msg = "log message";
        $execLevel = "emergency";

        $config = new Container(false);
        $config->logLevel = $this->toLogLevelValue($execLevel);
        $config->format = "%m";
        $logger = $this->getLogger($config);

        ob_start();
        $logger->{$logLevel}($msg);
        $actual = ob_get_clean();

        $this->assertEquals($isWrite, trim($actual) === $msg);
    }

    /**
     * 正常系
     * ログレベルが「fatal」のとき、
     * 「fatal」レベルのログが書き出せること
     * @test
     * @dataProvider logLevelFatalProvider
     */
    public function okWriteFatal($logLevel, $isWrite)
    {
        $msg = "log message";
        $execLevel = "fatal";

        $config = new Container(false);
        $config->logLevel = $this->toLogLevelValue($execLevel);
        $config->format = "%m";
        $logger = $this->getLogger($config);

        ob_start();
        $logger->{$logLevel}($msg);
        $actual = ob_get_clean();

        $this->assertEquals($isWrite, trim($actual) === $msg);
    }

    /**
     * 正常系
     * 指定されたフォーマットでログ出力されること
     * @test
     * @dataProvider loggerFormatterProvider
     */
    public function okLoggerFormatter($format, $applicationName, $msg, $formattedMessage)
    {
        $config = new Container(false);
        $config->logLevel = $this->toLogLevelValue("debug");
        $config->applicationName = $applicationName;
        $config->format = $format;
        $logger = $this->getLogger($config);

        ob_start();
        $logger->debug($msg);
        $actual = ob_get_clean();

        $this->assertEquals(trim($actual), $formattedMessage);
    }

    /**
     * 正常系
     * DateTimeフォーマットでログ出力されること
     * @test
     * @dataProvider loggerFormatterDateTimeProvider
     */
    public function okLoggerDateTimeFormatter($format, $dateTimeRegexp, $message, $messageWithSpace)
    {
        $config = new Container(false);
        $config->logLevel = $this->toLogLevelValue("debug");
        $config->format = $format;
        $logger = $this->getLogger($config);

        ob_start();
        $logger->debug($message);
        $actual = ob_get_clean();

        preg_match($dateTimeRegexp, $actual, $matches);
        $this->assertEquals(trim($actual), $matches[1] . $messageWithSpace);
    }

    // /**
    //  * 正常系
    //  * ログ設定ファイルにローテート設定が日単位かつ
    //  * ログファイル作成日が24時間以内の場合、
    //  * ログローテートは実行されないこと
    //  * @test
    //  * @dataProvider rotateCycleDayWithinProvider
    //  */
    // public function okRotateCycleWithinDay($rotateCycle, $hour)
    // {
    //     $config = new Container(false);
    //     $config->logLevel = $this->toLogLevelValue("debug");
    //     $config->format = "%m";
    //     $config->rotateCycle = $rotateCycle;
    //
    //
    //
    //     $logger = $this->getLogger($config);
    //
    //     // 既存のステータスファイルは削除
    //     $root = ServiceLocator::getInstance()->getContainer()->applicationInfo->applicationRoot;
    //     $statusPath = $root . "/log/webstream.test.status";
    //     if (file_exists($statusPath)) {
    //         unlink($statusPath);
    //     }
    //     // 現在時刻より$hour時間前のUnixTimeを取得
    //     $now = intval(preg_replace('/^.*\s/', '', microtime()));
    //     $created_at = $now - 3600 * $hour;
    //     $created_at_date = date("YmdHis", $created_at);
    //     $now_date = date("YmdHis", $now);
    //     // ローテートファイル名(作成されないが)
    //     $rotatedLogPath = $root . "/log/webstream.test.${created_at_date}-${now_date}.log";
    //     // テスト用のステータスファイルを作成
    //     file_put_contents($statusPath, $created_at);
    //     // ログ書き出し
    //     $configPath = $this->getLogConfigPath() . "/" . $configPath;
    //     $this->write("INFO", $configPath, "test");
    //     // ローテートされたかチェック
    //     $this->assertFalse(file_exists($rotatedLogPath));
    // }
}
