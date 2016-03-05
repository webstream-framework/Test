<?php
namespace WebStream\Test\UnitTest\DataProvider;

/**
 * HelperProvider
 * @author Ryuichi TANAKA.
 * @since 2016/01/16
 * @version 0.7
 */
trait HelperProvider
{
    public function helperTemplateProvider()
    {
        return [
            [1, "/test", "unit_test#test_found_helper", "h"]
        ];
    }

    public function helperEncodeProvider()
    {
        return [
            [2, "/test", "unit_test#test_html_escape", "<p>yryr</p>", "&lt;p&gt;yryr&lt;/p&gt;"],
            [3, "/test", "unit_test#test_javascript_escape", "<script>alert('test');</script>", '\x3cscript\x3ealert(\u0022test\u0022);\x3c\/script\x3e']
        ];
    }
}
