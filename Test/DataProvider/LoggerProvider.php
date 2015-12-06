<?php
namespace WebStream\Test\DataProvider;

/**
 * LogProvider
 * @author Ryuichi TANAKA.
 * @since 2013/09/07
 * @version 0.4
 */
trait LoggerProvider
{
    public function logLevelDebugProvider()
    {
        return [
            ["DEBUG",     "log.test.debug.ok.ini", "log message for debug1."],
            ["DEBUG",     "log.test.debug.ok.ini", "log message for debug2.", "#0 /path/to/test.php(0)"],
            ["INFO",      "log.test.debug.ok.ini", "log message for debug3."],
            ["INFO",      "log.test.debug.ok.ini", "log message for debug4.", "#0 /path/to/test.php(0)"],
            ["NOTICE",    "log.test.debug.ok.ini", "log message for debug5."],
            ["NOTICE",    "log.test.debug.ok.ini", "log message for debug6.", "#0 /path/to/test.php(0)"],
            ["WARN",      "log.test.debug.ok.ini", "log message for debug7."],
            ["WARN",      "log.test.debug.ok.ini", "log message for debug8.", "#0 /path/to/test.php(0)"],
            ["WARNING",   "log.test.debug.ok.ini", "log message for debug9."],
            ["WARNING",   "log.test.debug.ok.ini", "log message for debug10.", "#0 /path/to/test.php(0)"],
            ["ERROR",     "log.test.debug.ok.ini", "log message for debug11."],
            ["ERROR",     "log.test.debug.ok.ini", "log message for debug12.", "#0 /path/to/test.php(0)"],
            ["CRITICAL",  "log.test.debug.ok.ini", "log message for debug13."],
            ["CRITICAL",  "log.test.debug.ok.ini", "log message for debug14.", "#0 /path/to/test.php(0)"],
            ["ALERT",     "log.test.debug.ok.ini", "log message for debug15."],
            ["ALERT",     "log.test.debug.ok.ini", "log message for debug16.", "#0 /path/to/test.php(0)"],
            ["EMERGENCY", "log.test.debug.ok.ini", "log message for debug17."],
            ["EMERGENCY", "log.test.debug.ok.ini", "log message for debug18.", "#0 /path/to/test.php(0)"],
            ["FATAL",     "log.test.debug.ok.ini", "log message for debug19."],
            ["FATAL",     "log.test.debug.ok.ini", "log message for debug20.", "#0 /path/to/test.php(0)"]
        ];
    }

    public function logLevelInfoProvider()
    {
        return [
            ["DEBUG",     "log.test.info.ok.ini", "log message for info1."],
            ["DEBUG",     "log.test.info.ok.ini", "log message for info2.", "#0 /path/to/test.php(0)"],
            ["INFO",      "log.test.info.ok.ini", "log message for info3."],
            ["INFO",      "log.test.info.ok.ini", "log message for info4.", "#0 /path/to/test.php(0)"],
            ["NOTICE",    "log.test.info.ok.ini", "log message for info5."],
            ["NOTICE",    "log.test.info.ok.ini", "log message for info6.", "#0 /path/to/test.php(0)"],
            ["WARN",      "log.test.info.ok.ini", "log message for info7."],
            ["WARN",      "log.test.info.ok.ini", "log message for info8.", "#0 /path/to/test.php(0)"],
            ["WARNING",   "log.test.info.ok.ini", "log message for info9."],
            ["WARNING",   "log.test.info.ok.ini", "log message for info10.", "#0 /path/to/test.php(0)"],
            ["ERROR",     "log.test.info.ok.ini", "log message for info11."],
            ["ERROR",     "log.test.info.ok.ini", "log message for info12.", "#0 /path/to/test.php(0)"],
            ["CRITICAL",  "log.test.info.ok.ini", "log message for info13."],
            ["CRITICAL",  "log.test.info.ok.ini", "log message for info14.", "#0 /path/to/test.php(0)"],
            ["ALERT",     "log.test.info.ok.ini", "log message for info15."],
            ["ALERT",     "log.test.info.ok.ini", "log message for info16.", "#0 /path/to/test.php(0)"],
            ["EMERGENCY", "log.test.info.ok.ini", "log message for info17."],
            ["EMERGENCY", "log.test.info.ok.ini", "log message for info18.", "#0 /path/to/test.php(0)"],
            ["FATAL",     "log.test.info.ok.ini", "log message for info19."],
            ["FATAL",     "log.test.info.ok.ini", "log message for info20.", "#0 /path/to/test.php(0)"]
        ];
    }

    public function logLevelWarnProvider()
    {
        return [
            ["DEBUG",     "log.test.warn.ok.ini", "log message for warn1."],
            ["DEBUG",     "log.test.warn.ok.ini", "log message for warn2.", "#0 /path/to/test.php(0)"],
            ["INFO",      "log.test.warn.ok.ini", "log message for warn3."],
            ["INFO",      "log.test.warn.ok.ini", "log message for warn4.", "#0 /path/to/test.php(0)"],
            ["NOTICE",    "log.test.warn.ok.ini", "log message for warn5."],
            ["NOTICE",    "log.test.warn.ok.ini", "log message for warn6.", "#0 /path/to/test.php(0)"],
            ["WARN",      "log.test.warn.ok.ini", "log message for warn7."],
            ["WARN",      "log.test.warn.ok.ini", "log message for warn8.", "#0 /path/to/test.php(0)"],
            ["WARNING",   "log.test.warn.ok.ini", "log message for warn9."],
            ["WARNING",   "log.test.warn.ok.ini", "log message for warn10.", "#0 /path/to/test.php(0)"],
            ["ERROR",     "log.test.warn.ok.ini", "log message for warn11."],
            ["ERROR",     "log.test.warn.ok.ini", "log message for warn12.", "#0 /path/to/test.php(0)"],
            ["CRITICAL",  "log.test.warn.ok.ini", "log message for warn13."],
            ["CRITICAL",  "log.test.warn.ok.ini", "log message for warn14.", "#0 /path/to/test.php(0)"],
            ["ALERT",     "log.test.warn.ok.ini", "log message for warn15."],
            ["ALERT",     "log.test.warn.ok.ini", "log message for warn16.", "#0 /path/to/test.php(0)"],
            ["EMERGENCY", "log.test.warn.ok.ini", "log message for warn17."],
            ["EMERGENCY", "log.test.warn.ok.ini", "log message for warn18.", "#0 /path/to/test.php(0)"],
            ["FATAL",     "log.test.warn.ok.ini", "log message for warn19."],
            ["FATAL",     "log.test.warn.ok.ini", "log message for warn20.", "#0 /path/to/test.php(0)"]
        ];
    }

    public function logLevelErrorProvider()
    {
        return [
            ["DEBUG",     "log.test.error.ok.ini", "log message for error1."],
            ["DEBUG",     "log.test.error.ok.ini", "log message for error2.", "#0 /path/to/test.php(0)"],
            ["INFO",      "log.test.error.ok.ini", "log message for error3."],
            ["INFO",      "log.test.error.ok.ini", "log message for error4.", "#0 /path/to/test.php(0)"],
            ["NOTICE",    "log.test.error.ok.ini", "log message for error5."],
            ["NOTICE",    "log.test.error.ok.ini", "log message for error6.", "#0 /path/to/test.php(0)"],
            ["WARN",      "log.test.error.ok.ini", "log message for error7."],
            ["WARN",      "log.test.error.ok.ini", "log message for error8.", "#0 /path/to/test.php(0)"],
            ["WARNING",   "log.test.error.ok.ini", "log message for error9."],
            ["WARNING",   "log.test.error.ok.ini", "log message for error10.", "#0 /path/to/test.php(0)"],
            ["ERROR",     "log.test.error.ok.ini", "log message for error11."],
            ["ERROR",     "log.test.error.ok.ini", "log message for error12.", "#0 /path/to/test.php(0)"],
            ["CRITICAL",  "log.test.error.ok.ini", "log message for error13."],
            ["CRITICAL",  "log.test.error.ok.ini", "log message for error14.", "#0 /path/to/test.php(0)"],
            ["ALERT",     "log.test.error.ok.ini", "log message for error15."],
            ["ALERT",     "log.test.error.ok.ini", "log message for error16.", "#0 /path/to/test.php(0)"],
            ["EMERGENCY", "log.test.error.ok.ini", "log message for error17."],
            ["EMERGENCY", "log.test.error.ok.ini", "log message for error18.", "#0 /path/to/test.php(0)"],
            ["FATAL",     "log.test.error.ok.ini", "log message for error19."],
            ["FATAL",     "log.test.error.ok.ini", "log message for error20.", "#0 /path/to/test.php(0)"]
        ];
    }

    public function logLevelFatalProvider()
    {
        return [
            ["DEBUG",     "log.test.fatal.ok.ini", "log message for fatal1."],
            ["DEBUG",     "log.test.fatal.ok.ini", "log message for fatal2.", "#0 /path/to/test.php(0)"],
            ["INFO",      "log.test.fatal.ok.ini", "log message for fatal3."],
            ["INFO",      "log.test.fatal.ok.ini", "log message for fatal4.", "#0 /path/to/test.php(0)"],
            ["NOTICE",    "log.test.fatal.ok.ini", "log message for fatal5."],
            ["NOTICE",    "log.test.fatal.ok.ini", "log message for fatal6.", "#0 /path/to/test.php(0)"],
            ["WARN",      "log.test.fatal.ok.ini", "log message for fatal7."],
            ["WARN",      "log.test.fatal.ok.ini", "log message for fatal8.", "#0 /path/to/test.php(0)"],
            ["WARNING",   "log.test.fatal.ok.ini", "log message for fatal9."],
            ["WARNING",   "log.test.fatal.ok.ini", "log message for fatal10.", "#0 /path/to/test.php(0)"],
            ["ERROR",     "log.test.fatal.ok.ini", "log message for fatal11."],
            ["ERROR",     "log.test.fatal.ok.ini", "log message for fatal12.", "#0 /path/to/test.php(0)"],
            ["CRITICAL",  "log.test.fatal.ok.ini", "log message for fatal13."],
            ["CRITICAL",  "log.test.fatal.ok.ini", "log message for fatal14.", "#0 /path/to/test.php(0)"],
            ["ALERT",     "log.test.fatal.ok.ini", "log message for fatal15."],
            ["ALERT",     "log.test.fatal.ok.ini", "log message for fatal16.", "#0 /path/to/test.php(0)"],
            ["EMERGENCY", "log.test.fatal.ok.ini", "log message for fatal17."],
            ["EMERGENCY", "log.test.fatal.ok.ini", "log message for fatal18.", "#0 /path/to/test.php(0)"],
            ["FATAL",     "log.test.fatal.ok.ini", "log message for fatal19."],
            ["FATAL",     "log.test.fatal.ok.ini", "log message for fatal20.", "#0 /path/to/test.php(0)"]
        ];
    }

    public function logLevelNoticeProvider()
    {
        return [
            ["DEBUG",     "log.test.notice.ok.ini", "log message for notice1."],
            ["DEBUG",     "log.test.notice.ok.ini", "log message for notice2.", "#0 /path/to/test.php(0)"],
            ["INFO",      "log.test.notice.ok.ini", "log message for notice3."],
            ["INFO",      "log.test.notice.ok.ini", "log message for notice4.", "#0 /path/to/test.php(0)"],
            ["NOTICE",    "log.test.notice.ok.ini", "log message for notice5."],
            ["NOTICE",    "log.test.notice.ok.ini", "log message for notice6.", "#0 /path/to/test.php(0)"],
            ["WARN",      "log.test.notice.ok.ini", "log message for notice7."],
            ["WARN",      "log.test.notice.ok.ini", "log message for notice8.", "#0 /path/to/test.php(0)"],
            ["WARNING",   "log.test.notice.ok.ini", "log message for notice9."],
            ["WARNING",   "log.test.notice.ok.ini", "log message for notice10.", "#0 /path/to/test.php(0)"],
            ["ERROR",     "log.test.notice.ok.ini", "log message for notice11."],
            ["ERROR",     "log.test.notice.ok.ini", "log message for notice12.", "#0 /path/to/test.php(0)"],
            ["CRITICAL",  "log.test.notice.ok.ini", "log message for notice13."],
            ["CRITICAL",  "log.test.notice.ok.ini", "log message for notice14.", "#0 /path/to/test.php(0)"],
            ["ALERT",     "log.test.notice.ok.ini", "log message for notice15."],
            ["ALERT",     "log.test.notice.ok.ini", "log message for notice16.", "#0 /path/to/test.php(0)"],
            ["EMERGENCY", "log.test.notice.ok.ini", "log message for notice17."],
            ["EMERGENCY", "log.test.notice.ok.ini", "log message for notice18.", "#0 /path/to/test.php(0)"],
            ["FATAL",     "log.test.notice.ok.ini", "log message for notice19."],
            ["FATAL",     "log.test.notice.ok.ini", "log message for notice20.", "#0 /path/to/test.php(0)"]
        ];
    }

    public function logLevelWarningProvider()
    {
        return [
            ["DEBUG",     "log.test.warning.ok.ini", "log message for warn1."],
            ["DEBUG",     "log.test.warning.ok.ini", "log message for warn2.", "#0 /path/to/test.php(0)"],
            ["INFO",      "log.test.warning.ok.ini", "log message for warn3."],
            ["INFO",      "log.test.warning.ok.ini", "log message for warn4.", "#0 /path/to/test.php(0)"],
            ["NOTICE",    "log.test.warning.ok.ini", "log message for warn5."],
            ["NOTICE",    "log.test.warning.ok.ini", "log message for warn6.", "#0 /path/to/test.php(0)"],
            ["WARN",      "log.test.warning.ok.ini", "log message for warn7."],
            ["WARN",      "log.test.warning.ok.ini", "log message for warn8.", "#0 /path/to/test.php(0)"],
            ["WARNING",   "log.test.warning.ok.ini", "log message for warn9."],
            ["WARNING",   "log.test.warning.ok.ini", "log message for warn10.", "#0 /path/to/test.php(0)"],
            ["ERROR",     "log.test.warning.ok.ini", "log message for warn11."],
            ["ERROR",     "log.test.warning.ok.ini", "log message for warn12.", "#0 /path/to/test.php(0)"],
            ["CRITICAL",  "log.test.warning.ok.ini", "log message for warn13."],
            ["CRITICAL",  "log.test.warning.ok.ini", "log message for warn14.", "#0 /path/to/test.php(0)"],
            ["ALERT",     "log.test.warning.ok.ini", "log message for warn15."],
            ["ALERT",     "log.test.warning.ok.ini", "log message for warn16.", "#0 /path/to/test.php(0)"],
            ["EMERGENCY", "log.test.warning.ok.ini", "log message for warn17."],
            ["EMERGENCY", "log.test.warning.ok.ini", "log message for warn18.", "#0 /path/to/test.php(0)"],
            ["FATAL",     "log.test.warning.ok.ini", "log message for warn19."],
            ["FATAL",     "log.test.warning.ok.ini", "log message for warn20.", "#0 /path/to/test.php(0)"]
        ];
    }

    public function logLevelCriticalProvider()
    {
        return [
            ["DEBUG",     "log.test.critical.ok.ini", "log message for critical1."],
            ["DEBUG",     "log.test.critical.ok.ini", "log message for critical2.", "#0 /path/to/test.php(0)"],
            ["INFO",      "log.test.critical.ok.ini", "log message for critical3."],
            ["INFO",      "log.test.critical.ok.ini", "log message for critical4.", "#0 /path/to/test.php(0)"],
            ["NOTICE",    "log.test.critical.ok.ini", "log message for critical5."],
            ["NOTICE",    "log.test.critical.ok.ini", "log message for critical6.", "#0 /path/to/test.php(0)"],
            ["WARN",      "log.test.critical.ok.ini", "log message for critical7."],
            ["WARN",      "log.test.critical.ok.ini", "log message for critical8.", "#0 /path/to/test.php(0)"],
            ["WARNING",   "log.test.critical.ok.ini", "log message for critical9."],
            ["WARNING",   "log.test.critical.ok.ini", "log message for critical10.", "#0 /path/to/test.php(0)"],
            ["ERROR",     "log.test.critical.ok.ini", "log message for critical11."],
            ["ERROR",     "log.test.critical.ok.ini", "log message for critical12.", "#0 /path/to/test.php(0)"],
            ["CRITICAL",  "log.test.critical.ok.ini", "log message for critical13."],
            ["CRITICAL",  "log.test.critical.ok.ini", "log message for critical14.", "#0 /path/to/test.php(0)"],
            ["ALERT",     "log.test.critical.ok.ini", "log message for critical15."],
            ["ALERT",     "log.test.critical.ok.ini", "log message for critical16.", "#0 /path/to/test.php(0)"],
            ["EMERGENCY", "log.test.critical.ok.ini", "log message for critical17."],
            ["EMERGENCY", "log.test.critical.ok.ini", "log message for critical18.", "#0 /path/to/test.php(0)"],
            ["FATAL",     "log.test.critical.ok.ini", "log message for critical19."],
            ["FATAL",     "log.test.critical.ok.ini", "log message for critical20.", "#0 /path/to/test.php(0)"]
        ];
    }

    public function logLevelAlertProvider()
    {
        return [
            ["DEBUG",     "log.test.alert.ok.ini", "log message for alert1."],
            ["DEBUG",     "log.test.alert.ok.ini", "log message for alert2.", "#0 /path/to/test.php(0)"],
            ["INFO",      "log.test.alert.ok.ini", "log message for alert3."],
            ["INFO",      "log.test.alert.ok.ini", "log message for alert4.", "#0 /path/to/test.php(0)"],
            ["NOTICE",    "log.test.alert.ok.ini", "log message for alert5."],
            ["NOTICE",    "log.test.alert.ok.ini", "log message for alert6.", "#0 /path/to/test.php(0)"],
            ["WARN",      "log.test.alert.ok.ini", "log message for alert7."],
            ["WARN",      "log.test.alert.ok.ini", "log message for alert8.", "#0 /path/to/test.php(0)"],
            ["WARNING",   "log.test.alert.ok.ini", "log message for alert9."],
            ["WARNING",   "log.test.alert.ok.ini", "log message for alert10.", "#0 /path/to/test.php(0)"],
            ["ERROR",     "log.test.alert.ok.ini", "log message for alert11."],
            ["ERROR",     "log.test.alert.ok.ini", "log message for alert12.", "#0 /path/to/test.php(0)"],
            ["CRITICAL",  "log.test.alert.ok.ini", "log message for alert13."],
            ["CRITICAL",  "log.test.alert.ok.ini", "log message for alert14.", "#0 /path/to/test.php(0)"],
            ["ALERT",     "log.test.alert.ok.ini", "log message for alert15."],
            ["ALERT",     "log.test.alert.ok.ini", "log message for alert16.", "#0 /path/to/test.php(0)"],
            ["EMERGENCY", "log.test.alert.ok.ini", "log message for alert17."],
            ["EMERGENCY", "log.test.alert.ok.ini", "log message for alert18.", "#0 /path/to/test.php(0)"],
            ["FATAL",     "log.test.alert.ok.ini", "log message for alert19."],
            ["FATAL",     "log.test.alert.ok.ini", "log message for alert20.", "#0 /path/to/test.php(0)"]
        ];
    }

    public function logLevelEmergencyProvider()
    {
        return [
            ["DEBUG",     "log.test.emergency.ok.ini", "log message for emergency1."],
            ["DEBUG",     "log.test.emergency.ok.ini", "log message for emergency2.", "#0 /path/to/test.php(0)"],
            ["INFO",      "log.test.emergency.ok.ini", "log message for emergency3."],
            ["INFO",      "log.test.emergency.ok.ini", "log message for emergency4.", "#0 /path/to/test.php(0)"],
            ["NOTICE",    "log.test.emergency.ok.ini", "log message for emergency5."],
            ["NOTICE",    "log.test.emergency.ok.ini", "log message for emergency6.", "#0 /path/to/test.php(0)"],
            ["WARN",      "log.test.emergency.ok.ini", "log message for emergency7."],
            ["WARN",      "log.test.emergency.ok.ini", "log message for emergency8.", "#0 /path/to/test.php(0)"],
            ["WARNING",   "log.test.emergency.ok.ini", "log message for emergency9."],
            ["WARNING",   "log.test.emergency.ok.ini", "log message for emergency10.", "#0 /path/to/test.php(0)"],
            ["ERROR",     "log.test.emergency.ok.ini", "log message for emergency11."],
            ["ERROR",     "log.test.emergency.ok.ini", "log message for emergency12.", "#0 /path/to/test.php(0)"],
            ["CRITICAL",  "log.test.emergency.ok.ini", "log message for emergency13."],
            ["CRITICAL",  "log.test.emergency.ok.ini", "log message for emergency14.", "#0 /path/to/test.php(0)"],
            ["ALERT",     "log.test.emergency.ok.ini", "log message for emergency15."],
            ["ALERT",     "log.test.emergency.ok.ini", "log message for emergency16.", "#0 /path/to/test.php(0)"],
            ["EMERGENCY", "log.test.emergency.ok.ini", "log message for emergency17."],
            ["EMERGENCY", "log.test.emergency.ok.ini", "log message for emergency18.", "#0 /path/to/test.php(0)"],
            ["FATAL",     "log.test.emergency.ok.ini", "log message for emergency19."],
            ["FATAL",     "log.test.emergency.ok.ini", "log message for emergency20.", "#0 /path/to/test.php(0)"]
        ];
    }

    public function logAdapterProvider()
    {
        return [
            ["DEBUG",     "log.test.debug.ok.ini",     "log message for debug."],
            ["INFO",      "log.test.info.ok.ini",      "log message for info."],
            ["NOTICE",    "log.test.notice.ok.ini",    "log message for notice."],
            ["WARN",      "log.test.warn.ok.ini",      "log message for warn."],
            ["WARNING",   "log.test.warning.ok.ini",   "log message for warning."],
            ["ERROR",     "log.test.error.ok.ini",     "log message for error."],
            ["CRITICAL",  "log.test.critical.ok.ini",  "log message for critical."],
            ["ALERT",     "log.test.alert.ok.ini",     "log message for alert."],
            ["EMERGENCY", "log.test.emergency.ok.ini", "log message for emergency."],
            ["FATAL",     "log.test.fatal.ok.ini",     "log message for fatal."]
        ];
    }

    public function logAdapterWithPlaceholderProvider()
    {
        return [
            ["DEBUG", "log.test.debug.ok.ini", "log message for debug.", "log message for { level }.", ["level" => "debug"]],
            ["DEBUG", "log.test.debug.ok.ini", "log message for debug.", "log message for {level }.", ["level" => "debug"]],
            ["DEBUG", "log.test.debug.ok.ini", "log message for debug.", "log message for { level}.", ["level" => "debug"]],
            ["DEBUG", "log.test.debug.ok.ini", "log message for debug.", "log message for {level}.", ["level" => "debug"]]
        ];
    }

    public function rotateCycleDayWithinProvider()
    {
        return [
            ["log.test.ok1.rotate.ini", 1],
            ["log.test.ok1.rotate.ini", 23]
        ];
    }

    public function rotateCycleDayProvider()
    {
        return [
            ["log.test.ok1.rotate.ini", 24],
            ["log.test.ok1.rotate.ini", 25]
        ];
    }

    public function rotateCycleWeekWithinProvider()
    {
        return [
            ["log.test.ok2.rotate.ini", 24],
            ["log.test.ok2.rotate.ini", 24 * 7 -1]
        ];
    }

    public function rotateCycleWeekProvider()
    {
        return [
            ["log.test.ok2.rotate.ini", 24 * 7],
            ["log.test.ok2.rotate.ini", 24 * 7 + 1]
        ];
    }

    public function rotateCycleMonthWithinProvider()
    {
        $day_of_month = 24 * intval(date("t", time()));

        return [
            ["log.test.ok3.rotate.ini", 24],
            ["log.test.ok3.rotate.ini", $day_of_month - 1]
        ];
    }

    public function rotateCycleMonthProvider()
    {
        $day_of_month = 24 * intval(date("t", time()));

        return [
            ["log.test.ok3.rotate.ini", $day_of_month],
            ["log.test.ok3.rotate.ini", $day_of_month + 1]
        ];
    }

    public function rotateCycleYearWithinProvider()
    {
        $day_of_year = 24 * 365;
        $year = date("Y");
        if (($year % 4 === 0 && $year % 100 !== 0) || $year % 400 === 0) {
            $day_of_year = 24 * 366;
        }

        return [
            ["log.test.ok4.rotate.ini", 24],
            ["log.test.ok4.rotate.ini", $day_of_year - 1]
        ];
    }

    public function rotateCycleYearProvider()
    {
        $day_of_year = 24 * 365;
        $year = date("Y");
        if (($year % 4 === 0 && $year % 100 !== 0) || $year % 400 === 0) {
            $day_of_year = 24 * 366;
        }

        return array(
            array("log.test.ok4.rotate.ini", $day_of_year),
            array("log.test.ok4.rotate.ini", $day_of_year + 1)
        );
    }

    public function rotateSizeProvider()
    {
        return [
            ["log.test.ok5.rotate.ini", 1024],
            ["log.test.ok5.rotate.ini", 1025]
        ];
    }

    public function rotateSizeWithinProvider()
    {
        return [
            ["log.test.ok5.rotate.ini", 1023],
            ["log.test.ok5.rotate.ini", 0]
        ];
    }

    public function notFoundRotateCycleConfigProvider()
    {
        return [
            ["log.test.ng1.rotate.ini"]
        ];
    }

    public function invalidRotateCycleConfigProvider()
    {
        return [
            ["log.test.ng2.rotate.ini"]
        ];
    }

    public function notFoundRotateSizeConfigProvider()
    {
        return [
            ["log.test.ng3.rotate.ini"]
        ];
    }

    public function invalidRotateSizeConfigProvider()
    {
        return [
            ["log.test.ng4.rotate.ini"]
        ];
    }

    public function loggerAdapterInMvscLayerProvider()
    {
        return [
            ['/test_logger_adapter1', "controller logger"],
            ['/test_logger_adapter2', "service logger"],
            ['/test_logger_adapter3', "model logger"],
            ['/test_logger_adapter4', "helper logger"]
        ];
    }
}
