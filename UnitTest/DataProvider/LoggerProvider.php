<?php
namespace WebStream\Test\UnitTest\DataProvider;

/**
 * LoggerProvider
 * @author Ryuichi TANAKA.
 * @since 2016/01/30
 * @version 0.7
 */
trait LoggerProvider
{
    public function loggerAdapterProvider()
    {
        return [
            ["debug"],
            ["info"],
            ["notice"],
            ["warn"],
            ["warning"],
            ["error"],
            ["critical"],
            ["alert"],
            ["emergency"],
            ["fatal"]
        ];
    }

    public function loggerAdapterWithPlaceholderProvider()
    {
        return [
            ["debug", "log message for debug.", "log message for { level }.", ["level" => "debug"]],
            ["debug", "log message for debug.", "log message for {level }.", ["level" => "debug"]],
            ["debug", "log message for debug.", "log message for { level}.", ["level" => "debug"]],
            ["debug", "log message for debug.", "log message for {level}.", ["level" => "debug"]]
        ];
    }

    public function logLevelDebugProvider()
    {
        return [
            ["debug", true],
            ["info", true],
            ["notice", true],
            ["warn", true],
            ["warning", true],
            ["error", true],
            ["critical", true],
            ["alert", true],
            ["emergency", true],
            ["fatal", true]
        ];
    }

    public function logLevelInfoProvider()
    {
        return [
            ["debug", false],
            ["info", true],
            ["notice", true],
            ["warn", true],
            ["warning", true],
            ["error", true],
            ["critical", true],
            ["alert", true],
            ["emergency", true],
            ["fatal", true]
        ];
    }

    public function logLevelNoticeProvider()
    {
        return [
            ["debug", false],
            ["info", false],
            ["notice", true],
            ["warn", true],
            ["warning", true],
            ["error", true],
            ["critical", true],
            ["alert", true],
            ["emergency", true],
            ["fatal", true]
        ];
    }

    public function logLevelWarnProvider()
    {
        return [
            ["debug", false],
            ["info", false],
            ["notice", false],
            ["warn", true],
            ["warning", true],
            ["error", true],
            ["critical", true],
            ["alert", true],
            ["emergency", true],
            ["fatal", true]
        ];
    }

    public function logLevelWarningProvider()
    {
        return [
            ["debug", false],
            ["info", false],
            ["notice", false],
            ["warn", true],
            ["warning", true],
            ["error", true],
            ["critical", true],
            ["alert", true],
            ["emergency", true],
            ["fatal", true]
        ];
    }

    public function logLevelErrorProvider()
    {
        return [
            ["debug", false],
            ["info", false],
            ["notice", false],
            ["warn", false],
            ["warning", false],
            ["error", true],
            ["critical", true],
            ["alert", true],
            ["emergency", true],
            ["fatal", true]
        ];
    }

    public function logLevelCriticalProvider()
    {
        return [
            ["debug", false],
            ["info", false],
            ["notice", false],
            ["warn", false],
            ["warning", false],
            ["error", false],
            ["critical", true],
            ["alert", true],
            ["emergency", true],
            ["fatal", true]
        ];
    }

    public function logLevelAlertProvider()
    {
        return [
            ["debug", false],
            ["info", false],
            ["notice", false],
            ["warn", false],
            ["warning", false],
            ["error", false],
            ["critical", false],
            ["alert", true],
            ["emergency", true],
            ["fatal", true]
        ];
    }

    public function logLevelEmergencyProvider()
    {
        return [
            ["debug", false],
            ["info", false],
            ["notice", false],
            ["warn", false],
            ["warning", false],
            ["error", false],
            ["critical", false],
            ["alert", false],
            ["emergency", true],
            ["fatal", true]
        ];
    }

    public function logLevelFatalProvider()
    {
        return [
            ["debug", false],
            ["info", false],
            ["notice", false],
            ["warn", false],
            ["warning", false],
            ["error", false],
            ["critical", false],
            ["alert", false],
            ["emergency", false],
            ["fatal", true]
        ];
    }

    public function loggerFormatterProvider()
    {
        return [
            ["%m", "", "message", "message"],
            ["[%l] %m", "", "message", "[debug] message"],
            ["[%L] %m", "", "message", "[DEBUG] message"],
            ["[%10l] %m", "", "message", "[debug     ] message"],
            ["[%10L] %m", "", "message", "[DEBUG     ] message"],
            ["[%c] %m", "webstream", "message", "[webstream] message"]
        ];
    }

    public function loggerFormatterDateTimeProvider()
    {
        return [
            ["%d%m", "/(\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}:\d{2})/", "message", "message"],
            ["%d{%Y-%m-%d %H:%M:%S.%f}%m", "/(\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}:\d{2}\.\d{3})/", "message", "message"],
            ["%30d%m", "/(\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}:\d{2})/", "message", "           message"],
            ["%30d{%Y-%m-%d %H:%M:%S.%f}%m", "/(\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}:\d{2}\.\d{3})/", "message", "       message"]
        ];
    }

    public function unRotateByCycleProvider()
    {
        $day_of_year = 24 * 365;
        $year = date("Y");
        if (($year % 4 === 0 && $year % 100 !== 0) || $year % 400 === 0) {
            $day_of_year = 24 * 366;
        }

        return [
            ["day", 1],
            ["day", 23],
            ["week", 24],
            ["week", 24 * 7 - 1],
            ["month", 24 * intval(date("t", time())) - 1],
            ["year", $day_of_year - 1]
        ];
    }

    public function rotateByCycleProvider()
    {
        $day_of_month = intval(date("t", time()));
        $day_of_year = 24 * 365;
        $year = date("Y");
        if (($year % 4 === 0 && $year % 100 !== 0) || $year % 400 === 0) {
            $day_of_year = 24 * 366;
        }

        return [
            ["day", 24],
            ["day", 25],
            ["week", 24 * 7],
            ["week", 24 * 7 + 1],
            ["month", 24 * $day_of_month],
            ["month", 24 * $day_of_month + 1],
            ["year", $day_of_year],
            ["year", $day_of_year + 1]
        ];
    }

    public function unRotateBySizeProvider()
    {
        return [
            [1, 1023]
        ];
    }

    public function rotateBySizeProvider()
    {
        return [
            [1, 1024],
            [1, 1025]
        ];
    }
}
