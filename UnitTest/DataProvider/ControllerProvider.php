<?php
namespace WebStream\Test\UnitTest\DataProvider;

/**
 * ControllerProvider
 * @author Ryuichi TANAKA.
 * @since 2016/01/05
 * @version 0.7
 */
trait ControllerProvider
{
    public function runControllerProvider()
    {
        return [
            ["/test", "unit_test#found_controller", "c"],
            ["/test", "unit_test#multi_case1_controller", "c"],
            ["/test", "unit_test#multi_case2_controller", "c"]
        ];
    }

    public function runControllerPlaceholderParameterProvider()
    {
        // プレースホルダの組み合わせ自体はRouterTestでテストする
        return [
            ["/test/:id", "/test/lovelive", "unit_test#test_param", "lovelive"],
            ["/test/:id", "/test/ラブライブ", "unit_test#test_param", "ラブライブ"],
            ["/test/:id", "/test/<lovelive>", "unit_test#test_param", "<lovelive>"]
        ];
    }

    public function runControllerRequestParameterProvider()
    {
        return [
            ["get", "/test", "unit_test#test_get", "name", "honoka"],
            ["get", "/test", "unit_test#test_get", "name", "ﾎﾉｶﾁｬﾝ"],
            ["post", "/test", "unit_test#test_post", "name", "kotori"],
            ["post", "/test", "unit_test#test_post", "name", "(・8・)ｺﾄﾘ"],
            ["put", "/test", "unit_test#test_put", "name", "umichang"],
            ["put", "/test", "unit_test#test_put", "name", "ｳﾐﾁｬｰ"]
        ];
    }

    public function runControllerStaticFileProvider()
    {
        return [
            ["file.xml"],
            ["/subdir/file.xml"]
        ];
    }

    public function notRunControllerProvider()
    {
        return [
            ["/test", "unit_test#test", "/notfound", 404]
        ];
    }

    public function notRunServiceAndModelProvider()
    {
        return [
            ["/test", "unit_test#test_notfound_service_and_notfound_model", "WebStream\Delegate\CoreExceptionDelegator500"]
        ];
    }
}
