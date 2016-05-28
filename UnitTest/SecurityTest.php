<?php
namespace WebStream\Test\UnitTest;

use WebStream\Delegate\Router;
use WebStream\Module\Security;
use WebStream\Module\Utility\SecurityUtils;
use WebStream\Test\UnitTest\DataProvider\SecurityProvider;

require_once dirname(__FILE__) . '/TestBase.php';
require_once dirname(__FILE__) . '/DataProvider/SecurityProvider.php';

/**
 * SecurityTest
 * @author Ryuichi TANAKA.
 * @since 2011/09/21
 * @version 0.7
 */
class SecurityTest extends \PHPUnit_Framework_TestCase
{
    use SecurityUtils, SecurityProvider;

    public function setUp()
    {
        parent::setUp();
    }

    /**
     * 正常系
     * URLエンコード済みの文字列に制御文字列がある場合、削除されること
     * @test
     * @dataProvider deleteInvisibleCharacterProvider
     */
    public function okDeleteInvisibleCharacter($withinInvisibleStr, $withoutInvisibleStr)
    {
        $this->assertEquals(Security::safetyIn($withinInvisibleStr), rawurldecode($withoutInvisibleStr));
        $this->assertEquals(Security::safetyIn([$withinInvisibleStr])[0], rawurldecode($withoutInvisibleStr));
    }

    /**
     * 正常系
     * XSS文字列を置換できること
     * @test
     * @dataProvider replaceXSSStringProvider
     */
    public function okReplaceXSSString($withinXssHtml, $withoutXssHtml)
    {
        $this->assertEquals(Security::safetyOut($withinXssHtml), $withoutXssHtml);
        $this->assertEquals(Security::safetyOut([$withinXssHtml])[0], $withoutXssHtml);
    }

    /**
     * 正常系
     * XSSJavaScriptを置換できること
     * @test
     * @dataProvider replaceXSSJavaScriptProvider
     */
    public function okReplaceXSSJavaScript($withinXssJavaScript, $withoutXssJavaScript)
    {
        $this->assertEquals(Security::safetyOutJavaScript($withinXssJavaScript), $withoutXssJavaScript);
        $this->assertEquals(Security::safetyOutJavaScript([$withinXssJavaScript])[0], $withoutXssJavaScript);
    }

    /**
     * 正常系
     * XSSXMLを置換できること
     * @test
     * @dataProvider replaceXSSXmlProvider
     */
    public function okReplaceXSSXml($withinXssXml, $withoutXssXml)
    {
        $this->assertEquals(Security::safetyOutXML($withinXssXml), $withoutXssXml);
    }

    /**
     * 正常系
     * SecurityUtilsが正常に動作すること
     * @test
     */
    public function okSecurityUtil()
    {
        $this->assertEquals($this->getCsrfTokenKey(), "__CSRF_TOKEN__");
        $this->assertEquals($this->getCsrfTokenHeader(), "X-CSRF-Token");
        $this->assertEquals($this->encode("hoge"), "czo0OiJob2dlIjs=");
        $this->assertEquals($this->decode("czo0OiJob2dlIjs="), "hoge");
    }

    /**
     * 異常系
     * 文字列以外は安全な値に置換されないこと
     * @test
     * @dataProvider ignoreReplaceProvider
     */
    public function ngIgnoreReplace($value, $type)
    {
        $this->assertEquals(Security::safetyIn($value), $value);
        $this->assertEquals(gettype(Security::safetyIn($value)), $type);
        $this->assertEquals(Security::safetyOut($value), $value);
        $this->assertEquals(gettype(Security::safetyOut($value)), $type);
        $this->assertEquals(Security::safetyOutJavaScript($value), $value);
        $this->assertEquals(gettype(Security::safetyOutJavaScript($value)), $type);
    }
}
