<?php
namespace WebStream\Test;

use WebStream\Log\Logger;
use WebStream\Log\LoggerAdapter;
use WebStream\Module\Utility;
use WebStream\Module\HttpClient;
use WebStream\Test\DataProvider\LoggerProvider;

require_once 'TestBase.php';
require_once 'TestConstant.php';
require_once 'DataProvider/LoggerProvider.php';

/**
 * LoggerTest
 * @author Ryuichi TANAKA.
 * @since 2011/08/25
 * @version 0.4
 */
class LoggerTest extends TestBase
{
    use Utility, LoggerProvider, TestConstant;

    public function setUp()
    {
    }

    public function tearDown()
    {
        $logPath = $this->getRoot() . "/" . $this->getLogFilePath();
        $handle = fopen($logPath, "w+");
        fclose($handle);
        chmod($logPath, 0777);
    }

    private function logTail($configPath)
    {
        $log = $this->parseConfig($configPath);
        $logPath = $this->getRoot() . "/" . $log["path"];
        $file = file($logPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        return array_pop($file);
    }

    private function write($level, $configPath, $msg, $stacktrace = null)
    {
        Logger::init($configPath);

        switch ($level) {
            case "DEBUG":
                Logger::debug($msg, $stacktrace);
                break;
            case "INFO":
                Logger::info($msg, $stacktrace);
                break;
            case "WARN":
                Logger::warn($msg, $stacktrace);
                break;
            case "ERROR":
                Logger::error($msg, $stacktrace);
                break;
            case "FATAL":
                Logger::fatal($msg, $stacktrace);
                break;
            case "NOTICE":
                Logger::notice($msg, $stacktrace);
                break;
            case "WARNING":
                Logger::warning($msg, $stacktrace);
                break;
            case "CRITICAL":
                Logger::critical($msg, $stacktrace);
                break;
            case "ALERT":
                Logger::alert($msg, $stacktrace);
                break;
            case "EMERGENCY":
                Logger::emergency($msg, $stacktrace);
                break;
        }
    }

    private function writeAdapter($logger, $level, $msg, array $context = [])
    {
        switch ($level) {
            case "DEBUG":
                $logger->debug($msg, $context);
                break;
            case "INFO":
                $logger->info($msg, $context);
                break;
            case "WARN":
                $logger->warn($msg, $context);
                break;
            case "ERROR":
                $logger->error($msg, $context);
                break;
            case "FATAL":
                $logger->fatal($msg, $context);
                break;
            case "NOTICE":
                $logger->notice($msg, $context);
                break;
            case "WARNING":
                $logger->warning($msg, $context);
                break;
            case "CRITICAL":
                $logger->critical($msg, $context);
                break;
            case "ALERT":
                $logger->alert($msg, $context);
                break;
            case "EMERGENCY":
                $logger->emergency($msg, $context);
                break;
        }
    }

    private function assertLog($level, $msg, $stacktrace, $lineTail)
    {
        if ($stacktrace === null) {
            if (preg_match('/^\[\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}:\d{2}\..{3}\]\[(.+?)\]\s(.*)$/', $lineTail, $matches)) {
                $target = [$level, $msg];
                $result = [trim($matches[1]), $matches[2]];
                $this->assertEquals($target, $result);
            } else {
                $this->assertTrue(false);
            }
        } else {
            if (preg_match('/^(\t#\d.*)/', $lineTail, $matches)) {
                $this->assertEquals($lineTail, $matches[1]);
            } else {
                $this->assertTrue(false);
            }
        }
    }

    /**
     * 正常系
     * LoggerAdapter経由でログが書き込めること
     * @test
     * @dataProvider logAdapterProvider
     */
    public function okLoggerAdapter($level, $configPath, $msg)
    {
        $configPath = $this->getLogConfigPath() . "/" . $configPath;
        Logger::init($configPath);
        $logger = new LoggerAdapter(Logger::getInstance());
        $this->writeAdapter($logger, $level, $msg);
        $lineTail = $this->logTail($configPath);
        $this->assertLog($level, $msg, null, $lineTail);
        Logger::finalize();
    }

    /**
     * 正常系
     * LoggerAdapter経由でログが書き込め、プレースホルダーで値を埋め込めること
     * @test
     * @dataProvider logAdapterWithPlaceholderProvider
     */
    public function okLoggerAdapterWithPlaceholder($level, $configPath, $msg1, $msg2, array $placeholder)
    {
        $configPath = $this->getLogConfigPath() . "/" . $configPath;
        Logger::init($configPath);
        $logger = new LoggerAdapter(Logger::getInstance());
        $this->writeAdapter($logger, $level, $msg2, $placeholder);
        $lineTail = $this->logTail($configPath);
        $this->assertLog($level, $msg1, null, $lineTail);
        Logger::finalize();
    }

    /**
     * 正常系
     * ログレベルが「debug」のとき、
     * 「debug」「info」「notice」「warn」「warning」「error」「critical」「alert」「emergency」「fatal」レベルのログが書き出せること
     * @test
     * @dataProvider logLevelDebugProvider
     */
    public function okWriteDebug($level, $configPath, $msg, $stacktrace = null)
    {
        $configPath = $this->getLogConfigPath() . "/" . $configPath;
        $this->write($level, $configPath, $msg, $stacktrace);
        $lineTail = $this->logTail($configPath);
        $this->assertLog($level, $msg, $stacktrace, $lineTail);
    }

    /**
     * 正常系
     * ログレベルが「info」のとき、
     * 「info」「notice」「warn」「warning」「error」「critical」「alert」「emergency」「fatal」レベルのログが書き出せること
     * @test
     * @dataProvider logLevelInfoProvider
     */
    public function okWriteInfo($level, $configPath, $msg, $stacktrace = null)
    {
        $configPath = $this->getLogConfigPath() . "/" . $configPath;
        $this->write($level, $configPath, $msg, $stacktrace);
        $lineTail = $this->logTail($configPath);

        if ($level === "DEBUG") {
            $this->assertNull($lineTail);
        } else {
            $this->assertLog($level, $msg, $stacktrace, $lineTail);
        }
    }

    /**
     * 正常系
     * ログレベルが「notice」のとき、
     * 「notice」「warn」「warning」「error」「critical」「alert」「emergency」「fatal」レベルのログが書き出せること
     * @test
     * @dataProvider logLevelNoticeProvider
     */
    public function testOkWriteNotice($level, $configPath, $msg, $stacktrace = null)
    {
        $configPath = $this->getLogConfigPath() . "/" . $configPath;
        $this->write($level, $configPath, $msg, $stacktrace);
        $lineTail = $this->logTail($configPath);

        if ($level === "DEBUG" || $level === "INFO") {
            $this->assertNull($lineTail);
        } else {
            $this->assertLog($level, $msg, $stacktrace, $lineTail);
        }
    }

    /**
     * 正常系
     * ログレベルが「warn」のとき、
     * 「warn」「warning」「error」「critical」「alert」「emergency」「fatal」レベルのログが書き出せること
     * @test
     * @dataProvider logLevelWarnProvider
     */
    public function okWriteWarn($level, $configPath, $msg, $stacktrace = null)
    {
        $configPath = $this->getLogConfigPath() . "/" . $configPath;
        $this->write($level, $configPath, $msg, $stacktrace);
        $lineTail = $this->logTail($configPath);

        if ($level === "DEBUG" || $level === "INFO" || $level === "NOTICE") {
            $this->assertNull($lineTail);
        } else {
            $this->assertLog($level, $msg, $stacktrace, $lineTail);
        }
    }

    /**
     * 正常系
     * ログレベルが「warning」のとき、
     * 「warn」「warning」「error」「critical」「alert」「emergency」「fatal」レベルのログが書き出せること
     * @test
     * @dataProvider logLevelWarningProvider
     */
    public function testOkWriteWarning($level, $configPath, $msg, $stacktrace = null)
    {
        $configPath = $this->getLogConfigPath() . "/" . $configPath;
        $this->write($level, $configPath, $msg, $stacktrace);
        $lineTail = $this->logTail($configPath);

        if ($level === "DEBUG" || $level === "INFO" || $level === "NOTICE") {
            $this->assertNull($lineTail);
        } else {
            $this->assertLog($level, $msg, $stacktrace, $lineTail);
        }
    }

    /**
     * 正常系
     * ログレベルが「error」のとき、
     * 「error」「critical」「alert」「emergency」「fatal」レベルのログが書き出せること
     * @test
     * @dataProvider logLevelErrorProvider
     */
    public function okWriteError($level, $configPath, $msg, $stacktrace = null)
    {
        $configPath = $this->getLogConfigPath() . "/" . $configPath;
        $this->write($level, $configPath, $msg, $stacktrace);
        $lineTail = $this->logTail($configPath);

        if ($level === "DEBUG" || $level === "INFO" || $level === "NOTICE" || $level === "WARN" || $level === "WARNING") {
            $this->assertNull($lineTail);
        } else {
            $this->assertLog($level, $msg, $stacktrace, $lineTail);
        }
    }

    /**
     * 正常系
     * ログレベルが「critical」のとき、
     * 「critical」「alert」「emergency」「fatal」レベルのログが書き出せること
     * @test
     * @dataProvider logLevelCriticalProvider
     */
    public function testOkWriteCritical($level, $configPath, $msg, $stacktrace = null)
    {
        $configPath = $this->getLogConfigPath() . "/" . $configPath;
        $this->write($level, $configPath, $msg, $stacktrace);
        $lineTail = $this->logTail($configPath);

        if ($level === "DEBUG" || $level === "INFO" || $level === "NOTICE" || $level === "WARN" || $level === "WARNING" ||
            $level === "ERROR") {
            $this->assertNull($lineTail);
        } else {
            $this->assertLog($level, $msg, $stacktrace, $lineTail);
        }
    }

    /**
     * 正常系
     * ログレベルが「alert」のとき、
     * 「alert」「emergency」「fatal」レベルのログが書き出せること
     * @test
     * @dataProvider logLevelAlertProvider
     */
    public function testOkWriteAlert($level, $configPath, $msg, $stacktrace = null)
    {
        $configPath = $this->getLogConfigPath() . "/" . $configPath;
        $this->write($level, $configPath, $msg, $stacktrace);
        $lineTail = $this->logTail($configPath);

        if ($level === "DEBUG" || $level === "INFO" || $level === "NOTICE" || $level === "WARN" || $level === "WARNING" ||
            $level === "ERROR" || $level === "CRITICAL") {
            $this->assertNull($lineTail);
        } else {
            $this->assertLog($level, $msg, $stacktrace, $lineTail);
        }
    }

    /**
     * 正常系
     * ログレベルが「emergency」のとき、
     * 「emergency」「fatal」レベルのログが書き出せること
     * @test
     * @dataProvider logLevelEmergencyProvider
     */
    public function testOkWriteEmergency($level, $configPath, $msg, $stacktrace = null)
    {
        $configPath = $this->getLogConfigPath() . "/" . $configPath;
        $this->write($level, $configPath, $msg, $stacktrace);
        $lineTail = $this->logTail($configPath);

        if ($level === "DEBUG" || $level === "INFO" || $level === "NOTICE" || $level === "WARN" || $level === "WARNING" ||
            $level === "ERROR" || $level === "CRITICAL" || $level === "ALERT") {
            $this->assertNull($lineTail);
        } else {
            $this->assertLog($level, $msg, $stacktrace, $lineTail);
        }
    }

    /**
     * 正常系
     * ログレベルが「fatal」のとき、
     * 「fatal」レベルのログが書き出せること
     * @test
     * @dataProvider logLevelFatalProvider
     */
    public function testOkWriteFatal($level, $configPath, $msg, $stacktrace = null)
    {
        $configPath = $this->getLogConfigPath() . "/" . $configPath;
        $this->write($level, $configPath, $msg, $stacktrace);
        $lineTail = $this->logTail($configPath);

        if ($level === "DEBUG" || $level === "INFO" || $level === "NOTICE" || $level === "WARN" || $level === "WARNING" ||
            $level === "ERROR" || $level === "CRITICAL" || $level === "ALERT" || $level === "EMERGENCY") {
            $this->assertNull($lineTail);
        } else {
            $this->assertLog($level, $msg, $stacktrace, $lineTail);
        }
    }

    /**
     * 正常系
     * ログ設定ファイルにローテート設定が日単位かつ
     * ログファイル作成日が24時間以内の場合、
     * ログローテートは実行されないこと
     * @test
     * @dataProvider rotateCycleDayWithinProvider
     */
    public function okRotateCycleWithinDay($configPath, $hour)
    {
        // 既存のステータスファイルは削除
        $statusPath = $this->getRoot() . "/log/webstream.test.status";
        if (file_exists($statusPath)) {
            unlink($statusPath);
        }
        // 現在時刻より$hour時間前のUnixTimeを取得
        $now = intval(preg_replace('/^.*\s/', '', microtime()));
        $created_at = $now - 3600 * $hour;
        $created_at_date = date("YmdHis", $created_at);
        $now_date = date("YmdHis", $now);
        // ローテートファイル名(作成されないが)
        $rotatedLogPath = $this->getRoot() . "/log/webstream.test.${created_at_date}-${now_date}.log";
        // テスト用のステータスファイルを作成
        file_put_contents($statusPath, $created_at);
        // ログ書き出し
        $configPath = $this->getLogConfigPath() . "/" . $configPath;
        $this->write("INFO", $configPath, "test");
        // ローテートされたかチェック
        $this->assertFalse(file_exists($rotatedLogPath));
    }

    /**
     * 正常系
     * ログ設定ファイルにローテート設定が日単位かつ
     * ログファイル作成日が24時間以上の場合、
     * ログローテートが実行されること
     * @test
     * @dataProvider rotateCycleDayProvider
     */
    public function okRotateCycleDay($configPath, $hour)
    {
        // 既存のステータスファイルは削除
        $statusPath = $this->getRoot() . "/log/webstream.test.status";
        if (file_exists($statusPath)) {
            unlink($statusPath);
        }
        // 現在時刻より$hour時間前のUnixTimeを取得
        $now = intval(preg_replace('/^.*\s/', '', microtime()));
        $created_at = $now - 3600 * $hour;
        $created_at_date = date("YmdHis", $created_at);
        $now_date = date("YmdHis", $now);
        // ローテートファイル名(作成されないが)
        $rotatedLogPath = $this->getRoot() . "/log/webstream.test.${created_at_date}-${now_date}.log";
        // テスト用のステータスファイルを作成
        file_put_contents($statusPath, $created_at);
        // ログ書き出し
        $configPath = $this->getLogConfigPath() . "/" . $configPath;
        $this->write("INFO", $configPath, "test");
        // ローテートされたかチェック
        $this->assertFileExists($rotatedLogPath);
        // ローテートしたログファイルを削除
        if (file_exists($rotatedLogPath)) {
            unlink($rotatedLogPath);
        }
    }

    /**
     * 正常系
     * ログ設定ファイルにローテート設定が
     * 週単位かつログファイル作成日が1週間以内の場合、
     * ログローテートは実行されないこと
     * @test
     * @dataProvider rotateCycleWeekWithinProvider
     */
    public function okRotateCycleWithinWeek($configPath, $hour)
    {
        // 既存のステータスファイルは削除
        $statusPath = $this->getRoot() . "/log/webstream.test.status";
        if (file_exists($statusPath)) {
            unlink($statusPath);
        }
        // 現在時刻より$hour時間前のUnixTimeを取得
        $now = intval(preg_replace('/^.*\s/', '', microtime()));
        $created_at = $now - 3600 * $hour;
        $created_at_date = date("YmdHis", $created_at);
        $now_date = date("YmdHis", $now);
        // ローテートファイル名(作成されないが)
        $rotatedLogPath = $this->getRoot() . "/log/webstream.test.${created_at_date}-${now_date}.log";
        // テスト用のステータスファイルを作成
        file_put_contents($statusPath, $created_at);
        // ログ書き出し
        $configPath = $this->getLogConfigPath() . "/" . $configPath;
        $this->write("INFO", $configPath, "test");
        // ローテートされたかチェック
        $this->assertFalse(file_exists($rotatedLogPath));
    }

    /**
     * 正常系
     * ログ設定ファイルにローテート設定が週単位かつ
     * ログファイル作成日が1週間以上の場合、
     * ログローテートが実行されること
     * @test
     * @dataProvider rotateCycleWeekProvider
     */
    public function okRotateCycleWeek($configPath, $hour)
    {
        // 既存のステータスファイルは削除
        $statusPath = $this->getRoot() . "/log/webstream.test.status";
        if (file_exists($statusPath)) {
            unlink($statusPath);
        }
        // 現在時刻より$hour時間前のUnixTimeを取得
        $now = intval(preg_replace('/^.*\s/', '', microtime()));
        $created_at = $now - 3600 * $hour;
        $created_at_date = date("YmdHis", $created_at);
        $now_date = date("YmdHis", $now);
        // ローテートファイル名(作成されないが)
        $rotatedLogPath = $this->getRoot() . "/log/webstream.test.${created_at_date}-${now_date}.log";
        // テスト用のステータスファイルを作成
        file_put_contents($statusPath, $created_at);
        // ログ書き出し
        $configPath = $this->getLogConfigPath() . "/" . $configPath;
        $this->write("INFO", $configPath, "test");
        // ローテートされたかチェック
        $this->assertFileExists($rotatedLogPath);
        // ローテートしたログファイルを削除
        if (file_exists($rotatedLogPath)) {
            unlink($rotatedLogPath);
        }
    }

    /**
     * 正常系
     * ログ設定ファイルにローテート設定が月単位かつ
     * ログファイル作成日が1ヶ月以内の場合、
     * ログローテートは実行されないこと
     * @test
     * @dataProvider rotateCycleMonthWithinProvider
     */
    public function okRotateCycleWithinMonth($configPath, $hour)
    {
        // 既存のステータスファイルは削除
        $statusPath = $this->getRoot() . "/log/webstream.test.status";
        if (file_exists($statusPath)) {
            unlink($statusPath);
        }
        // 現在時刻より$hour時間前のUnixTimeを取得
        $now = intval(preg_replace('/^.*\s/', '', microtime()));
        $created_at = $now - 3600 * $hour;
        $created_at_date = date("YmdHis", $created_at);
        $now_date = date("YmdHis", $now);
        // ローテートファイル名(作成されないが)
        $rotatedLogPath = $this->getRoot() . "/log/webstream.test.${created_at_date}-${now_date}.log";
        // テスト用のステータスファイルを作成
        file_put_contents($statusPath, $created_at);
        // ログ書き出し
        $configPath = $this->getLogConfigPath() . "/" . $configPath;
        $this->write("INFO", $configPath, "test");
        // ローテートされたかチェック
        $this->assertFalse(file_exists($rotatedLogPath));
    }

    /**
     * 正常系
     * ログ設定ファイルにローテート設定が月単位かつ
     * ログファイル作成日が1ヶ月以上の場合、
     * ログローテートが実行されること
     * @test
     * @dataProvider rotateCycleMonthProvider
     */
    public function okRotateCycleMonth($configPath, $hour)
    {
        // 既存のステータスファイルは削除
        $statusPath = $this->getRoot() . "/log/webstream.test.status";
        if (file_exists($statusPath)) {
            unlink($statusPath);
        }
        // 現在時刻より$hour時間前のUnixTimeを取得
        $now = intval(preg_replace('/^.*\s/', '', microtime()));
        $created_at = $now - 3600 * $hour;
        $created_at_date = date("YmdHis", $created_at);
        $now_date = date("YmdHis", $now);
        // ローテートファイル名(作成されないが)
        $rotatedLogPath = $this->getRoot() . "/log/webstream.test.${created_at_date}-${now_date}.log";
        // テスト用のステータスファイルを作成
        file_put_contents($statusPath, $created_at);
        // ログ書き出し
        $configPath = $this->getLogConfigPath() . "/" . $configPath;
        $this->write("INFO", $configPath, "test");
        // ローテートされたかチェック
        $this->assertFileExists($rotatedLogPath);
        // ローテートしたログファイルを削除
        if (file_exists($rotatedLogPath)) {
            unlink($rotatedLogPath);
        }
    }

    /**
     * 正常系
     * ログ設定ファイルにローテート設定が年単位かつ
     * ログファイル作成日が1年以内の場合、
     * ログローテートは実行されないこと
     * @test
     * @dataProvider rotateCycleYearWithinProvider
     */
    public function okRotateCycleWithinYear($configPath, $hour)
    {
        // 既存のステータスファイルは削除
        $statusPath = $this->getRoot() . "/log/webstream.test.status";
        if (file_exists($statusPath)) {
            unlink($statusPath);
        }
        // 現在時刻より$hour時間前のUnixTimeを取得
        $now = intval(preg_replace('/^.*\s/', '', microtime()));
        $created_at = $now - 3600 * $hour;
        $created_at_date = date("YmdHis", $created_at);
        $now_date = date("YmdHis", $now);
        // ローテートファイル名(作成されないが)
        $rotatedLogPath = $this->getRoot() . "/log/webstream.test.${created_at_date}-${now_date}.log";
        // テスト用のステータスファイルを作成
        file_put_contents($statusPath, $created_at);
        // ログ書き出し
        $configPath = $this->getLogConfigPath() . "/" . $configPath;
        $this->write("INFO", $configPath, "test");
        // ローテートされたかチェック
        $this->assertFalse(file_exists($rotatedLogPath));
    }

    /**
     * 正常系
     * ログ設定ファイルにローテート設定が年単位かつ
     * ログファイル作成日が1年以上の場合、
     * ログローテートが実行されること
     * @test
     * @dataProvider rotateCycleYearProvider
     */
    public function testOkRotateCycleYear($configPath, $hour)
    {
        // 既存のステータスファイルは削除
        $statusPath = $this->getRoot() . "/log/webstream.test.status";
        if (file_exists($statusPath)) {
            unlink($statusPath);
        }
        // 現在時刻より$hour時間前のUnixTimeを取得
        $now = intval(preg_replace('/^.*\s/', '', microtime()));
        $created_at = $now - 3600 * $hour;
        $created_at_date = date("YmdHis", $created_at);
        $now_date = date("YmdHis", $now);
        // ローテートファイル名(作成されないが)
        $rotatedLogPath = $this->getRoot() . "/log/webstream.test.${created_at_date}-${now_date}.log";
        // テスト用のステータスファイルを作成
        file_put_contents($statusPath, $created_at);
        // ログ書き出し
        $configPath = $this->getLogConfigPath() . "/" . $configPath;
        $this->write("INFO", $configPath, "test");
        // ローテートされたかチェック
        $this->assertFileExists($rotatedLogPath);
        // ローテートしたログファイルを削除
        if (file_exists($rotatedLogPath)) {
            unlink($rotatedLogPath);
        }
    }

    /**
     * 正常系
     * ログ設定ファイルにローテート設定(サイズ単位)されていて、現在のログサイズが
     * 指定値以上の場合、ログローテートが実行されること
     * @test
     * @dataProvider rotateSizeProvider
     */
    public function okRotateSize($configPath, $byte)
    {
        // ログファイルに1024バイトのデータを書き込む
        $logPath = $this->getRoot() . "/" . $this->getLogFilePath();
        $handle = fopen($logPath, "w");
        for ($i = 0; $i < $byte; $i++) {
            fwrite($handle, "a");
        }
        fclose($handle);

        // ログ書き出し
        $configPath = $this->getLogConfigPath() . "/" . $configPath;
        $this->write("INFO", $configPath, "test");

        $now = intval(preg_replace('/^.*\s/', '', microtime()));
        $now_date = $created_at_date = date("YmdHis", $now);
        // ローテートファイル名
        $rotatedLogPath = $this->getRoot() . "/log/webstream.test.${created_at_date}-${now_date}.log";
        // ローテートされていればローテートしたログファイルが存在する
        $this->assertFileExists($rotatedLogPath);
        // ローテートしたログファイルを削除
        if (file_exists($rotatedLogPath)) {
            unlink($rotatedLogPath);
        }
    }

    /**
     * 正常系
     * ログ設定ファイルにローテート設定(サイズ単位)されていて、現在のログサイズが
     * 指定値より小さい場合、ログローテートが実行されないこと
     * @test
     * @dataProvider rotateSizeWithinProvider
     */
    public function okRotateSizeWithin($configPath, $byte)
    {
        // ログファイルに1023バイト以下のデータを書き込む
        $logPath = $this->getRoot() . "/" . $this->getLogFilePath();
        $handle = fopen($logPath, "w");
        for ($i = 0; $i < $byte; $i++) {
            fwrite($handle, "a");
        }
        fclose($handle);

        // ログ書き出し
        $configPath = $this->getLogConfigPath() . "/" . $configPath;
        $this->write("INFO", $configPath, "test");

        $now = intval(preg_replace('/^.*\s/', '', microtime()));
        $now_date = $created_at_date = date("YmdHis", $now);
        // ローテートファイル名
        $rotatedLogPath = $this->getRoot() . "/log/webstream.test.${created_at_date}-${now_date}.log";
        // ローテートされたかチェック
        $this->assertFalse(file_exists($rotatedLogPath));
    }

    /**
     * 正常系
     * 各MVSCレイヤ内でロガーが使用できること
     * @test
     * @dataProvider loggerAdapterInMvscLayerProvider
     */
    public function okLoggerAdapterInMvscLayer($path, $response)
    {
        $http = new HttpClient();
        $url = $this->getDocumentRootURL() . $path;
        $html = $http->get($url);
        $this->assertEquals($http->getStatusCode(), 200);
        $this->assertNotFalse(strstr($html, $response));
    }

    /**
     * 正常系
     * 指定されたフォーマットでログ出力されること
     * @test
     * @dataProvider loggerFormatterProvider
     */
    public function okLoggerFormatter($configPath, $message, $formattedMessage)
    {
        $configPath = $this->getLogConfigPath() . "/" . $configPath;
        Logger::init($configPath);
        Logger::debug($message);
        $lineTail = $this->logTail($configPath);
        $this->assertEquals($lineTail, $formattedMessage);
    }

    /**
     * 正常系
     * DateTimeフォーマットでログ出力されること
     * @test
     * @dataProvider loggerFormatterDateTimeProvider
     */
    public function okLoggerDateTimeFormatter($configPath, $dateTimeRegexp, $message, $messageWithSpace)
    {
        $configPath = $this->getLogConfigPath() . "/" . $configPath;
        Logger::init($configPath);
        Logger::debug($message);
        $lineTail = $this->logTail($configPath);
        if (preg_match($dateTimeRegexp, $lineTail, $matches)) {
            $this->assertEquals($lineTail, $matches[1] . $messageWithSpace);
        } else {
            $this->assertTrue(false);
        }
    }

    /**
     * 異常系
     * Loggerを初期化していない場合、例外が発生すること
     * @test
     * @expectedException WebStream\Exception\Extend\LoggerException
     * @expectedExceptionMessage Logger is not initialized.
     */
    public function ngNotInitialized()
    {
        // オートロード有効
        $this->autoLoad();
        // 初期化を再現
        $refClass = new \ReflectionClass("\WebStream\Log\Logger");
        $refProp = $refClass->getProperty("logger");
        $refProp->setAccessible(true);
        $refProp->setValue(null);
        $refProp = $refClass->getProperty("configPath");
        $refProp->setAccessible(true);
        $refProp->setValue(null);
        $refMethod = $refClass->getMethod("__callStatic");
        $refMethod->invokeArgs(null, ["info", ["test"]]);
    }

    /**
     * 異常系
     * ログ設定ファイルが存在しない場合、例外が発生すること
     * @test
     * @expectedException WebStream\Exception\Extend\LoggerException
     * @expectedExceptionMessage Log config file does not exist: dummy.ini
     */
    public function ngConfigFileNotFound()
    {
        Logger::init("dummy.ini");
        $this->assertTrue(false);
    }

    /**
     * 異常系
     * ログ設定ファイルのログファイルパスが存在しない場合、例外が発生すること
     * @test
     * @expectedException WebStream\Exception\Extend\LoggerException
     */
    public function ngInvalidConfigPath()
    {
        $configPath = $this->getLogConfigPath() . "/log.test.ng1.ini";
        Logger::init($configPath);
        $this->assertTrue(false);
    }

    /**
     * 異常系
     * ログ設定ファイルのログレベルが不正な場合、例外が発生すること
     * @test
     * @expectedException WebStream\Exception\Extend\LoggerException
     */
    public function ngInvalidLogLevel()
    {
        $configPath = $this->getLogConfigPath() . "/log.test.ng2.ini";
        Logger::init($configPath);
        $this->assertTrue(false);
    }

    /**
     * 異常系
     * ログの書き込み権限がない場合、例外が発生すること
     * @test
     * @expectedException WebStream\Exception\Extend\LoggerException
     */
    public function ngNotPermittedWriteLog()
    {
        $configPath = $this->getLogConfigPath() . "/log.test.ng3.ini";
        Logger::init($configPath);
        Logger::info("test");
        $this->assertTrue(false);
    }

    /**
     * 異常系
     * 存在しないログレベルのメソッドアクセスがあった場合、例外が発生すること
     * @test
     * @expectedException WebStream\Exception\Extend\LoggerException
     */
    public function ngUndefinedLogLevel()
    {
        $configPath = $this->getLogConfigPath() . "/log.test.debug.ok.ini";
        Logger::init($configPath);
        Logger::undefined("test");
        $this->assertTrue(false);
    }

    /**
     * 異常系
     * 存在しないログレベルのメソッドアクセスがあった場合、例外が発生すること(LoggerAdapter使用)
     * @test
     * @expectedException WebStream\Exception\Extend\LoggerException
     */
    public function ngUndefinedLogLevelLoggerAdapter()
    {
        Logger::finalize();
        $configPath = $this->getLogConfigPath() . "/log.test.debug.ok.ini";
        Logger::init($configPath);
        $logger = new LoggerAdapter(Logger::getInstance());
        $logger->undefined("test");
        $this->assertTrue(false);
    }

    /**
     * 異常系
     * ログ設定ファイルにローテート設定(時間単位)が指定されない場合、
     * ステータスファイルが作成されないこと
     * @test
     * @dataProvider notFoundRotateCycleConfigProvider
     */
    public function ngNotFoundRotateCycleConfig($configPath)
    {
        $statusPath = $this->getRoot() . "/log/stream.status";
        if (file_exists($statusPath)) {
            unlink($statusPath);
        }
        $configPath = $this->getLogConfigPath() . "/" . $configPath;
        Logger::init($configPath);
        Logger::info("test");
        $this->assertFalse(file_exists($statusPath));
    }

    /**
     * 異常系
     * ログ設定ファイルのローテート設定(時間単位)が間違っている場合、
     * 例外が発生すること
     * @test
     * @dataProvider invalidRotateCycleConfigProvider
     * @expectedException WebStream\Exception\Extend\LoggerException
     * @expectedExceptionMessage Invalid log rotate cycle: dummy
     */
    public function ngInvalidRotateCycleConfig($configPath)
    {
        $configPath = $this->getLogConfigPath() . "/" . $configPath;
        Logger::init($configPath);
        Logger::info("test");
    }

    /**
     * 異常系
     * ログ設定ファイルにローテート設定(サイズ単位)が指定されない場合、
     * ステータスファイルが作成されないこと
     * @test
     * @dataProvider notFoundRotateSizeConfigProvider
     */
    public function ngNotFoundRotateSizeConfig($configPath)
    {
        $statusPath = $this->getRoot() . "/log/stream.status";
        if (file_exists($statusPath)) {
            unlink($statusPath);
        }
        $configPath = $this->getLogConfigPath() . "/" . $configPath;
        Logger::init($configPath);
        Logger::info("test");
        $this->assertFalse(file_exists($statusPath));
    }

    /**
     * 異常系
     * ログ設定ファイルのローテート設定(サイズ単位)が間違っている場合、
     * 例外が発生すること
     * @test
     * @dataProvider invalidRotateSizeConfigProvider
     * @expectedException WebStream\Exception\Extend\LoggerException
     * @expectedExceptionMessage Invalid log rotate size: dummy
     */
    public function ngInvalidRotateSizeConfig($configPath)
    {
        $configPath = $this->getLogConfigPath() . "/" . $configPath;
        Logger::init($configPath);
        Logger::info("test");
    }
}
