<?php
namespace WebStream\Test\IntegrationTest;

use WebStream\Module\HttpClient;
use WebStream\Test\IntegrationTest\DataProvider\MiddlewareProvider;

require_once dirname(__FILE__) . '/TestBase.php';
require_once dirname(__FILE__) . '/TestConstant.php';
require_once dirname(__FILE__) . '/DataProvider/MiddlewareProvider.php';

/**
 * MiddlewareTest
 * @author Ryuichi TANAKA.
 * @since 2016/07/11
 * @version 0.7
 */
class MiddlewareTest extends \PHPUnit_Framework_TestCase
{
    use MiddlewareProvider, TestConstant;

    /**
     * 正常系
     * 外部キャッシュライブラリを使用してキャッシュを利用できること
     * @test
     * @dataProvider cacheProvider
     */
    public function okCache($path, $response)
    {
        $http = new HttpClient();
        $html = $http->get($this->getDocumentRootURL() . $path);
        $this->assertEquals($html, $response);
    }
}
