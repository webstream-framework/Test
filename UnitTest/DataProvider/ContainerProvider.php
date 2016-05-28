<?php
namespace WebStream\Test\UnitTest\DataProvider;

/**
 * ContainerProvider
 * @author Ryuichi TANAKA.
 * @since 2016/05/29
 * @version 0.7
 */
trait ContainerProvider
{
    public function primitiveContainerProvider()
    {
        return [
            ["key", 1],
            ["key", "hoge"],
            ["key", true]
        ];
    }

    public function closureContainerProvider()
    {
        return [
            ["key", function () { return 1; }, 1],
            ["key", function () { return "hoge"; }, "hoge"],
            ["key", function () { return true; }, true]
        ];
    }

}
