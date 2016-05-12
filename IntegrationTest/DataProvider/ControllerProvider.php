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
            ["/controller/ok", "test1"],
            ["/controller/parent_class_method_access", "parent"]
        ];
    }

    public function controllerNotAccessProvider()
    {
        return [
            ["/controller/controller_method_noexist", 404]
        ];
    }
}
