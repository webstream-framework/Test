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
            ["/service/ok", "test1"]
        ];
    }

    public function serviceNotAccessProvider()
    {
        return [
            ["/service/service_method_noexist", 404],
            ["/service/service_class_noexist_and_model_class_noexist", 500]
        ];
    }
}
