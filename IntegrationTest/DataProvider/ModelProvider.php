<?php
namespace WebStream\Test\IntegrationTest\DataProvider;

/**
 * ModelProvider
 * @author Ryuichi TANAKA.
 * @since 2016/05/08
 * @version 0.7
 */
trait ModelProvider
{
    public function modelAccessProvider()
    {
        return [
            ["/model/test1", "test1"],
            ["/model_class_exist_and_service_class_noexist", "exist"]
        ];
    }
}
