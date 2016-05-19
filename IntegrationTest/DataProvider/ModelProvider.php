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
            ["/model/mysql/direct_insert_query", "direct_insert"],
            ["/model/mysql/annotation_insert_query", "annotation_insert"],
            ["/model/mysql/direct_update_query", "direct_update"],
            ["/model/mysql/annotation_update_query", "annotation_update"],
            ["/model/mysql/direct_delete_query", "0"],
            ["/model/mysql/annotation_delete_query", "0"],
            ["/model/mysql/yml", "direct_select"],
            ["/model/postgres/direct_select_query", "direct_select"],
            ["/model/postgres/annotation_select_query", "annotation_select"],
            ["/model/postgres/direct_insert_query", "direct_insert"],
            ["/model/postgres/annotation_insert_query", "annotation_insert"],
            ["/model/postgres/direct_update_query", "direct_update"],
            ["/model/postgres/annotation_update_query", "annotation_update"],
            ["/model/postgres/direct_delete_query", "0"],
            ["/model/postgres/annotation_delete_query", "0"],
            ["/model/sqlite/direct_select_query", "direct_select"],
            ["/model/sqlite/annotation_select_query", "annotation_select"],
            ["/model/sqlite/direct_insert_query", "direct_insert"],
            ["/model/sqlite/annotation_insert_query", "annotation_insert"],
            ["/model/sqlite/direct_update_query", "direct_update"],
            ["/model/sqlite/annotation_update_query", "annotation_update"],
            ["/model/sqlite/direct_delete_query", "0"],
            ["/model/sqlite/annotation_delete_query", "0"]
        ];
    }
}
