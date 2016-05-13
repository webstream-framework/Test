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
            ["/model/ok", "test1"],
            ["/model/service_class_noexist_and_model_class_exist", "exist"],
            ["/model/mysql/direct_select_query", "direct_select"],
            ["/model/mysql/annotation_select_query", "annotation_select"],
            ["/model/mysql/direct_insert_query", "direct_insert"]
        ];
    }
}
