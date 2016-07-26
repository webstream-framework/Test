<?php
namespace WebStream\Test\UnitTest;

use WebStream\Log\Logger;
use WebStream\Log\LoggerAdapter;
use WebStream\Log\LoggerConfigurationManager;
use WebStream\Log\Outputter\ConsoleOutputter;
use WebStream\IO\File;
use WebStream\IO\StringInputStream;
use WebStream\IO\Reader\InputStreamReader;
use WebStream\Cache\LoggerCache;
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
        // Logger::finalize();
    }

    private function getLogger(Container $config)
    {
        $config->logPath = "";
        $config->statusPath = "";
        Logger::init($config);
        $instance = Logger::getInstance();
        $instance->setOutputter([new ConsoleOutputter()]);

        return new LoggerAdapter($instance);
    }

    private function getRotatableLogger(Container $config, int $status, int $size = null)
    {
        $config->logPath = "dummy.log";
        $config->statusPath = "dummy.status";
        Logger::init($config);
        $instance = Logger::getInstance();
        $instance->setOutputter([new ConsoleOutputter()]);

        // IO処理をDI
        $ioContainer = new Container();
        $ioContainer->statusReader = function () use ($status) {
            return new class($status)
            {
                private $reader;
                public function __construct($status)
                {
                    $this->reader = new InputStreamReader(new StringInputStream($status));
                }

                public function read()
                {
                    $out = "";
                    while (($data = $this->reader->read()) !== null) {
                        $out .= $data;
                    }

                    return $out;
                }
            };
        };
        $ioContainer->statusWriter = function () {
            return new OutputStreamWriter(new ConsoleOutputStream());
        };
        $ioContainer->logWriter = function () {
            return new OutputStreamWriter(new ConsoleOutputStream());
        };

        // テスト用FileオブジェクトをDI
        $logFile = new class($config->logPath, $size) extends File
        {
            private $size;
            public function __construct($logPath, $size)
            {
                $this->size = $size;
                parent::__construct($logPath);
            }

            public function renameTo($filepath)
            {
                echo $filepath;
            }

            public function exists()
            {
                return true;
            }

            public function size()
            {
                return $this->size;
            }
        };
        $statusFile = new class($config->statusPath) extends File
        {
            public function delete()
            {
                return true;
            }

            public function exists()
            {
                return true;
            }
        };

        $instance->inject('ioContainer', $ioContainer)
                 ->inject('logFile', $logFile)
                 ->inject('statusFile', $statusFile);

        return new LoggerAdapter($instance);
    }

    private function cycle2value($cycle)
    {
        $day_to_h = 24;
        $week_to_h = $day_to_h * 7;
        $month_to_h = $day_to_h * intval(date("t", time()));
        $year_to_h = $day_to_h * 365;

        $year = date("Y");
        if (($year % 4 === 0 && $year % 100 !== 0) || $year % 400 === 0) {
            $year_to_h = $day_to_h * 366;
        }

        switch (strtolower($cycle)) {
            case 'day':
                return $day_to_h;
            case 'week':
                return $week_to_h;
            case 'month':
                return $month_to_h;
            case 'year':
                return $year_to_h;
            default:
                return 0;
        }
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
        $config->logPath = "";
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

    /**
     * 正常系
     * ログの書き出しタイミングを制御できること
     * @test
     * @dataProvider writeTimingProvider
     */
    public function okLoggerWriteTiming($isLazy, $msg1, $msg2, $msg3, $result)
    {
        $config = new Container(false);
        $config->logLevel = $this->toLogLevelValue("debug");
        $config->format = "%m";
        $config->logPath = "";
        $config->statusPath = "";
        Logger::init($config);
        $instance = Logger::getInstance();
        $outputter = new ConsoleOutputter(1);
        if ($isLazy) {
            $outputter->enableLazyWrite();
        } else {
            $outputter->enableDirectWrite();
        }
        $instance->setOutputter([$outputter]);

        $logger = new LoggerAdapter($instance);
        ob_start();
        $logger->debug($msg1);
        echo $msg2 . PHP_EOL;
        $logger->debug($msg3);
        if ($isLazy) {
            $logger->enableDirectWrite(); // バッファをクリアする
        }
        $actual = ob_get_clean();

        $this->assertEquals($actual, $result);
    }

    /**
     * 正常系
     * ローテート設定が
     * 日単位かつログファイル作成日24時間以内の場合、
     * 週単位かつログファイル作成日が1週間以内の場合、
     * 月単位かつログファイル作成日が1ヶ月以内の場合、
     * 年単位かつログファイル作成日が1年以内の場合、
     * ログローテートは実行されないこと
     * @test
     * @dataProvider unRotateByCycleProvider
     */
    public function okUnRotateByCycle($rotateCycle, $hour)
    {
        $message = "hoge";
        $config = new Container(false);
        $config->logLevel = $this->toLogLevelValue("debug");
        $config->format = "%m";
        $config->rotateCycle = $this->cycle2value($rotateCycle);

        // 現在時刻より$hour時間前のUnixTimeを取得
        $now = intval(preg_replace('/^.*\s/', '', microtime()));
        $createdAt = $now - 3600 * $hour;
        $createdAtDate = date("YmdHis", $createdAt);
        $nowDate = date("YmdHis", $now);

        $logger = $this->getRotatableLogger($config, $createdAt);
        $logger->info($message);

        $this->expectOutputString($message . PHP_EOL);
    }

    /**
     * 正常系
     * ローテート設定が
     * 日単位かつログファイル作成日が24時間以上の場合、
     * 週単位かつログファイル作成日が1週間以上の場合、
     * 月単位かつログファイル作成日が1ヶ月以上の場合、
     * 年単位かつログファイル作成日が1年以上の場合、
     * ログローテートが実行されること
     * @test
     * @dataProvider rotateByCycleProvider
     */
    public function okRotateByCycle($rotateCycle, $hour)
    {
        $message = "hoge";
        $config = new Container(false);
        $config->logLevel = $this->toLogLevelValue("debug");
        $config->format = "%m";
        $config->rotateCycle = $this->cycle2value($rotateCycle);

        // 現在時刻より$hour時間前のUnixTimeを取得
        $now = intval(preg_replace('/^.*\s/', '', microtime()));
        $createdAt = $now - 3600 * $hour;
        $createdAtDate = date("YmdHis", $createdAt);
        $nowDate = date("YmdHis", $now);

        $logger = $this->getRotatableLogger($config, $createdAt);
        $logger->info($message);

        $rotatedLogFile = "dummy.${createdAtDate}-${nowDate}.log";
        // ログローテートが発生するとファイル名を出力する設定にしている
        $this->expectOutputString($rotatedLogFile . $message . PHP_EOL);
    }

    /**
     * 正常系
     * ログ設定ファイルにローテート設定(サイズ単位)されていて、現在のログサイズが
     * 指定値より小さい場合、ログローテートが実行されないこと
     * @test
     * @dataProvider unRotateBySizeProvider
     */
    public function okUnRotateBySize($rotateSize, $writeSize)
    {
        $config = new Container(false);
        $config->logLevel = $this->toLogLevelValue("debug");
        $config->format = "%m";
        $config->rotateSize = $rotateSize; // KB単位

        $now = intval(preg_replace('/^.*\s/', '', microtime()));
        $logger = $this->getRotatableLogger($config, $now, $writeSize);
        $message = "";
        for ($i = 0; $i < $writeSize; $i++) {
            $message .= "a";
        }
        $logger->info($message);

        $this->expectOutputString($message . PHP_EOL);
    }

    /**
     * 正常系
     * ログ設定ファイルにローテート設定(サイズ単位)されていて、現在のログサイズが
     * 指定値より以上の場合、ログローテートが実行されること
     * @test
     * @dataProvider rotateBySizeProvider
     */
    public function okRotateBySize($rotateSize, $writeSize)
    {
        $config = new Container(false);
        $config->logLevel = $this->toLogLevelValue("debug");
        $config->format = "%m";
        $config->rotateSize = $rotateSize; // KB単位

        $now = intval(preg_replace('/^.*\s/', '', microtime()));
        $logger = $this->getRotatableLogger($config, $now, $writeSize);
        $message = "";
        for ($i = 0; $i < $writeSize; $i++) {
            $message .= "a";
        }
        $logger->info($message);

        $nowDate = date("YmdHis", $now);
        $rotatedLogFile = "dummy.${nowDate}-${nowDate}.log";

        $this->expectOutputString($rotatedLogFile . $message . PHP_EOL);
    }

    /**
     * 正常系
     * ログ設定を読み込めること
     * @test
     * @dataProvider loggerConfigurationProvider
     */
    public function okLoggerConfiguration($config)
    {
        $ioContainer = new Container();
        $ioContainer->file = function () {
            $filePath = "dummy";
            return new class($filePath) extends File
            {
                public function __construct($filePath)
                {
                    parent::__construct($filePath);
                }

                public function isFile()
                {
                    return true;
                }

                public function exists()
                {
                    return true;
                }
            };
        };

        Logger::finalize();
        $manager = new LoggerConfigurationManager($config);
        $manager->inject('ioContainer', $ioContainer);
        $manager->load();

        $this->assertInstanceOf('\WebStream\Module\Container', $manager->getConfig());
    }

    /**
     * 正常系
     * ログキャッシュできること
     * @test
     * @dataProvider loggerCacheDriverProvider
     */
    public function okLoggerCache($driver)
    {
        $cache = new LoggerCache($driver);
        $cache->add("a");
        $cache->add("b");
        $this->assertEquals(2, $cache->length());
        $this->assertEquals(implode("", $cache->get()), "ab");
    }

    /**
     * 正常系
     * ログファイルが見つからない場合、新規作成できること
     * @test
     * @dataProvider loggerNewLogFileProvider
     */
    public function okLoggerNewLogFile($config)
    {
        $ioContainer = new Container();
        $ioContainer->file = function () {
            $filePath = "dummy";
            return new class($filePath) extends File
            {
                public function __construct($filePath)
                {
                    parent::__construct($filePath);
                }

                public function isFile()
                {
                    return false;
                }

                public function exists()
                {
                    return false;
                }
            };
        };
        $ioContainer->fileWriter = function() {
            return new class()
            {
                public function write()
                {
                    echo "create new log file";
                }
            };
        };

        Logger::finalize();
        $manager = new LoggerConfigurationManager($config);
        $manager->inject('ioContainer', $ioContainer);
        $manager->load();

        $this->expectOutputString("create new log file");
    }

    /**
     * 異常系
     * ログ設定に誤りがある場合、例外が発生すること
     * @test
     * @dataProvider loggerConfigurationErrorProvider
     * @expectedException WebStream\Exception\Extend\LoggerException
     */
    public function ngLoggerConfiguration($config, $fileConfig = null)
    {
        $ioContainer = new Container();
        $ioContainer->file = function () use ($fileConfig) {
            $filePath = "dummy";
            return new class($filePath, $fileConfig) extends File
            {
                private $fileConfig;
                public function __construct($filePath, $fileConfig)
                {
                    $this->fileConfig = $fileConfig;
                    parent::__construct($filePath);
                }

                public function isFile()
                {
                    if ($this->fileConfig !== null && array_key_exists("isFile", $this->fileConfig)) {
                        return $this->fileConfig["isFile"];
                    } else {
                        return true;
                    }
                }

                public function exists()
                {
                    if ($this->fileConfig !== null && array_key_exists("exists", $this->fileConfig)) {
                        return $this->fileConfig["exists"];
                    } else {
                        return true;
                    }
                }
            };
        };

        Logger::finalize();
        $manager = new LoggerConfigurationManager($config);
        $manager->inject('ioContainer', $ioContainer);
        $manager->load();

        $this->assertTrue(false);
    }
}
