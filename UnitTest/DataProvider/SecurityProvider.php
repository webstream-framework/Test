<?php
namespace WebStream\Test\UnitTest\DataProvider;

/**
 * SecurityProvider
 * @author Ryuichi TANAKA.
 * @since 2013/09/03
 * @version 0.7
 */
trait SecurityProvider
{
    public function deleteInvisibleCharacterProvider()
    {
        return [
            ['%E3%81%82%00%08%09', '%E3%81%82%09'] // 00,08は制御文字
        ];
    }

    public function replaceXSSStringProvider()
    {
        return [
            ["<div>\\a\t\n\r\r\n<!-- --><![CDATA[</div>",
             '&lt;div&gt;\\\\a&nbsp;&nbsp;&nbsp;&nbsp;<br/><br/><br/>&lt;!-- --&gt;&lt;![CDATA[&lt;/div&gt;']
        ];
    }

    public function replaceXSSJavaScriptProvider()
    {
        return [
            ["<script></script>", '\x3cscript\x3e\x3c\/script\x3e']
        ];
    }

    public function replaceXSSXmlProvider()
    {
        return [
            ["\xD7FF", ""]
        ];
    }

    public function createCsrfTokenProvider()
    {
        return [
            ['/csrf', '/csrf_helper']
        ];
    }

    public function ignoreSafetyInProvider()
    {
        return [
            [1, "integer"],
            [true, "boolean"],
            [[1], "array"],
            [(object) "hoge", "object"]
        ];
    }
}
