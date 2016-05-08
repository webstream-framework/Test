<?php
namespace WebStream\Test\IntegrationTest\DataProvider;

/**
 * ControllerProvider
 * @author Ryuichi TANAKA.
 * @since 2016/05/08
 * @version 0.7
 */
trait ControllerProvider
{
    public function controllerAccessProvider()
    {
        return [
            ["/controller/test1", "test1"]
        ];
    }
}
