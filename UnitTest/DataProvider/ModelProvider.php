<?php
namespace WebStream\Test\UnitTest\DataProvider;

/**
 * ModelProvider
 * @author Ryuichi TANAKA.
 * @since 2016/01/09
 * @version 0.7
 */
trait ModelProvider
{
    public function runModelProvider()
    {
        return [
            ["/test", "unit_test#test_found_model", "m"]
        ];
    }

    public function executeCrudProvider()
    {
        return [
            ["/test", "unit_test#execute_select", "WebStream\Database\Result"],
            ["/test", "unit_test#execute_insert", "1"],
            ["/test", "unit_test#execute_update", "1"],
            ["/test", "unit_test#execute_delete", "1"]
        ];
    }

    public function executeCrudQueryFileProvider()
    {
        return [
            ["/test", "unit_test#execute_xml_query", "executeXmlQuery", "WebStream\Database\Result", "select"],
            ["/test", "unit_test#execute_xml_query", "executeXmlQuery", "1", "insert"],
            ["/test", "unit_test#execute_xml_query", "executeXmlQuery", "1", "update"],
            ["/test", "unit_test#execute_xml_query", "executeXmlQuery", "1", "delete"],
            ["/test", "unit_test#execute_xml_query_to_entity", "executeXmlQueryToEntity", "WebStream\Database\ResultEntity", "select", true]
        ];
    }
}
