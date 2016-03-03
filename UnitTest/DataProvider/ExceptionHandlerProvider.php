<?php
namespace WebStream\Test\UnitTest\DataProvider;

/**
 * ExceptionHandlerProvider
 * @author Ryuichi TANAKA.
 * @since 2016/03/03
 * @version 0.7
 */
trait ExceptionHandlerProvider
{
    public function excecptionProvider()
    {
        return [
            ["/test", "unit_test#validate_exception", "validator error"],
            ["/test", "unit_test#forbidden_access_exception", "forbidden access error"],
            ["/test", "unit_test#session_timeout_exception", "session timeout error"],
            ["/test", "unit_test#invalid_request_exception", "invalid request error"],
            ["/test", "unit_test#csrf_exception", "csrf error"],
            ["/test", "unit_test#resource_not_found_exception", "resource notfound error"],
            ["/test", "unit_test#class_not_found_exception", "class notfound error"],
            ["/test", "unit_test#method_not_found_exception", "method notfound error"],
            ["/test", "unit_test#annotation_exception", "annotation error"],
            ["/test", "unit_test#router_exception", "router error"],
        ];
    }
}
