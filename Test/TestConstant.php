<?php
namespace WebStream\Test;

trait TestConstant
{
    private function getDocumentRootURL()
    {
        return "http://" . gethostname() . "/webstream-framework/Test/TestApp";
    }

    private function getProjectRootPath()
    {
        if (preg_match('/(.+webstream-framework\/Test)/', dirname(__FILE__), $matches)) {
            return $matches[1] . "/TestApp";
        }
    }

    private function getLogFilePath()
    {
        return "/log/webstream.test.log";
    }

    private function getLogConfigPath()
    {
        return "/config/log_config";
    }

    private function getCacheDir777()
    {
        return "/cache777";
    }

    private function getCacheDir000()
    {
        return "/cache000";
    }

    private function getCacheDir()
    {
        return "/app/views/_cache";
    }

    private function getHtmlUrl()
    {
        return "http://www.yahoo.co.jp";
    }

    private function getJsonUrl()
    {
        return "http://tepco-usage-api.appspot.com/latest.json";
    }

    private function getRssUrl()
    {
        return "http://rss.dailynews.yahoo.co.jp/fc/rss.xml";
    }

    private function getBasicAuthUrl()
    {
        return "http://kensakuyoke.web.fc2.com/basic-test/test.html";
    }

    private function getNotFoundUrl()
    {
        return "http://wwww222.google.co.jp";
    }
}
