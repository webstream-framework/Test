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
            ["/controller/parent_class_method_access", "parent"],
            ["/controller/upper_method/1", "u"],
            ["/controller/upper_method/2", "u"],
            ["/controller/lower_method/1", "l"],
            ["/controller/lower_method/2", "l"]
        ];
    }

    public function controllerNotAccessProvider()
    {
        return [
            ["/controller/error/controller_method_noexist", "500"]
        ];
    }
}
