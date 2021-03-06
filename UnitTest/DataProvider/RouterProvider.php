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
    public function resolveRoutingProvider()
    {
        return [
            ["/test", "test#test_action", "TestController", "testAction"],
            ["/snakecase1", "test_snake#test_action", "TestSnakeController", "testAction"],
            ["/snakecase2", "test_snake_hoge_hoge#test_action", "TestSnakeHogeHogeController", "testAction"]
        ];
    }

    public function resolveRoutingPlaceholderProvider()
    {
        return [
            ["/test/:id", "/test/1", "test#test_action", "TestController", "testAction", "id", "1"],
            ["/test/:snake_id", "/test/1", "test#test_action", "TestController", "testAction", "snake_id", "1"],
            ["/test/:_snake_id", "/test/1", "test#test_action", "TestController", "testAction", "_snake_id", "1"],
            ["/test/:snake_id_", "/test/1", "test#test_action", "TestController", "testAction", "snake_id_", "1"],
            ["/test/file.:format", "/test/file.xml", "test#test_action", "TestController", "testAction", "format", "xml"],
            ["/test/:urlencode", "/test/%E3%81%A6%E3%81%99%E3%81%A8", "test#test_encode", "TestController", "testEncode", "urlencode", 'てすと']
        ];
    }

    public function resolveRoutingSimilarUrlProvider()
    {
        return [
            [
                ["/test/similar" => "test#test_action", "/test/similar/:id" => "test#test_action2"],
                "/test/similar/1",
                "TestController",
                "testAction2"
            ]
        ];
    }

    public function undefinedRoutingAccessProvider()
    {
        return [
            ["/test", "test#test_action", "/undefined"]
        ];
    }

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
            ["/img/hoge.jpg", "test#test_action"],
            ["/js/hoge.js", "test#test_action"],
            ["/css/hoge.css", "test#test_action"],
            ["/file/hoge.pdf", "test#test_action"]
        ];
    }
}
