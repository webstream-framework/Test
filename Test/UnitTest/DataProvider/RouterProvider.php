<?php
namespace WebStream\Test\UnitTest\DataProvider;

/**
 * RouterProvider
 * @author Ryuichi TANAKA.
 * @since 2013/09/21
 * @version 0.7
 */
trait RouterProvider
{
    // 正常系
    public function resolveRoutingProvider()
    {
        return [
            ["/test", "test#test_action", "TestController", "testAction"],
            ["/snakecase1", "test_snake#test_action", "TestSnakeController", "testAction"],
            ["/snakecase2", "test_snake_hoge_hoge#test_action", "TestSnakeHogeHogeController", "testAction"],
        ];
    }

    // 正常系
    public function resolveRoutingPlaceholderProvider()
    {
        return [
            ["/test/:id", "/test/1", "test#test_action", "TestController", "testAction", "id", "1"],
            ["/test/:snake_id", "/test/1", "test#test_action", "TestController", "testAction", "snake_id", "1"],
            ["/test/:_snake_id", "/test/1", "test#test_action", "TestController", "testAction", "_snake_id", "1"],
            ["/test/:snake_id_", "/test/1", "test#test_action", "TestController", "testAction", "snake_id_", "1"],
            ["/test/file.:format", "/test/file.xml", "test#test_action", "TestController", "testAction", "format", "xml"],
        ];
    }

    // 異常系
    public function unResolveRoutingProvider()
    {
        return [
            ["/controller_ng1", "test_#test_action"],
            ["/controller_ng2", "test__#test_action"],
            ["/controller_ng3", "test_snake_#test_action"],
            ["/controller_ng4", "test__snake#test_action"],
            ["/controller_ng5", "_test_snake#test_action"],
            ["/controller_ng6", "test_123#test_action"],
            ["/controller_ng7", "test!#test_action"],
            ["/controller_ng8", "testCamel#test_action"],
            ["/action_ng1", "test#test__action"],
            ["/action_ng2", "test#test_action_"],
            ["/action_ng3", "test#_test_action"],
            ["/action_ng4", "test#test_action_123"],
            ["/action_ng5", "test#testAction"],
            ["/param_ng1/:!", "test#test_action"],
        ];
    }
}
