<?php
namespace WebStream\Test\UnitTest;

use WebStream\Delegate\Router;
use WebStream\Module\Security;
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
    use SecurityProvider;

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
     * 異常系
     * 文字列以外は安全な値に置換されないこと
     * @test
     * @dataProvider ignoreSafetyInProvider
     */
    public function ngIgnoreSafetyIn($value, $type)
    {
        $this->assertEquals(Security::safetyIn($value), $value);
        $this->assertEquals(gettype(Security::safetyIn($value)), $type);
    }
}
