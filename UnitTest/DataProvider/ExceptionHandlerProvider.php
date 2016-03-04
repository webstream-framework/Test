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
            [1, "/test", "unit_test#exception_action", "exceptionAction"],
            [2, "/test", "unit_test#exception_action", "exceptionAction"],
            [3, "/test", "unit_test#exception_action1", "exceptionAction1"],
            [3, "/test", "unit_test#exception_action2", "exceptionAction2"],
            [4, "/test", "unit_test#exception_action1", "exceptionAction1"],
            [4, "/test", "unit_test#exception_action2", "exceptionAction2"],
        ];
    }
}
