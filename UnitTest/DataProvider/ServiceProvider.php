<?php
namespace WebStream\Test\UnitTest\DataProvider;

/**
 * ServiceProvider
 * @author Ryuichi TANAKA.
 * @since 2016/01/07
 * @version 0.7
 */
trait ServiceProvider
{
    public function runServiceProvider()
    {
        return [
            ["/test", "unit_test#test_found_service", "s"]
        ];
    }

    public function runServiceAndModelProvider()
    {
        return [
            ["/test", "unit_test#test_found_service_and_found_model", "sm"]
        ];
    }

    public function notRunServiceAndRunModelProvider()
    {
        return [
            ["/test", "unit_test#test_notfound_service_and_found_model", "m"],
            ["/test", "unit_test#test_notfound_service_and_found_model_argument", "m"],
        ];
    }

    public function notRunServiceAndModelProvider()
    {
        return [
            ["/test", "unit_test#test_notfound_service_and_notfound_model"]
        ];
    }
}
