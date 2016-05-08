<?php
namespace WebStream\Test\IntegrationTest\DataProvider;

/**
 * ServiceProvider
 * @author Ryuichi TANAKA.
 * @since 2016/05/08
 * @version 0.7
 */
trait ServiceProvider
{
    public function serviceAccessProvider()
    {
        return [
            ["/service/test1", "test1"]
        ];
    }
}
