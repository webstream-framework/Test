<?php
namespace WebStream\Test\UnitTest\DataProvider;

/**
 * HelperProvider
 * @author Ryuichi TANAKA.
 * @since 2016/01/16
 * @version 0.7
 */
trait HelperProvider
{
    public function runHelperTemplateProvider()
    {
        return [
            ["/test", "unit_test#test_found_helper", "h"]
        ];
    }
}
