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
    }

    /**
     * 正常系
     * XSS対象の文字列を置換できること
     * @test
     * @dataProvider replaceXSSStringsProvider
     */
    public function okReplaceXSSStrings($withinXssHtml, $withoutXssHtml)
    {
        $this->assertEquals(Security::safetyOut($withinXssHtml), $withoutXssHtml);
    }
}
