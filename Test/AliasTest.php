<?php
namespace WebStream\Test;

use WebStream\Module\HttpClient;
use WebStream\Test\DataProvider\AliasProvider;

require_once 'TestBase.php';
require_once 'TestConstant.php';
require_once 'DataProvider/AliasProvider.php';

/**
 * Aliasテストクラス
 * @author Ryuichi TANAKA.
 * @since 2015/12/09
 * @version 0.7
 */
class AliasTest extends TestBase
{
    use AliasProvider, TestConstant;

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
    }

    /**
     * 正常系
     * エイリアス経由で実メソッドにアクセスできること
     * @test
     * @dataProvider aliasAccessProvider
     */
    public function okAliasAccess($path, $response)
    {
        $http = new HttpClient();
        $path = $this->getDocumentRootURL() . $path;
        $responseText = $http->get($path);
        $this->assertEquals($response, $responseText);
        $this->assertEquals($http->getStatusCode(), 200);
    }

    /**
     * 正常系
     * エイリアス定義されたメソッドが実メソッドとしてすでに存在する場合、実メソッドアクセスになること
     * @test
     * @dataProvider originAccessProvider
     */
    public function okOriginAccess($path, $response)
    {
        $http = new HttpClient();
        $path = $this->getDocumentRootURL() . $path;
        $responseText = $http->get($path);
        $this->assertEquals($response, $responseText);
        $this->assertEquals($http->getStatusCode(), 200);
    }
}
