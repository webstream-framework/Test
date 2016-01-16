<?php
namespace WebStream\Test\UnitTest\DataProvider;

/**
 * ViewProvider
 * @author Ryuichi TANAKA.
 * @since 2016/01/16
 * @version 0.7
 */
trait ViewProvider
{
    public function runViewTemplateProvider()
    {
        return [
            ["/test", "unit_test#test_found_view", "v"]
        ];
    }
}
