<?php
namespace WebStream\Test\IntegrationTest;

use WebStream\Module\HttpClient;
use WebStream\Test\IntegrationTest\DataProvider\ControllerProvider;

require_once dirname(__FILE__) . '/TestBase.php';
require_once dirname(__FILE__) . '/TestConstant.php';
require_once dirname(__FILE__) . '/DataProvider/ControllerProvider.php';

/**
 * ControllerTest
 * @author Ryuichi TANAKA.
 * @since 2016/05/07
 * @version 0.7
 */
class ControllerTest extends \PHPUnit_Framework_TestCase
{
    use ControllerProvider, TestConstant;

    /**
     * 正常系
     * Controllerにアクセスできること
     * @test
     * @dataProvider controllerAccessProvider
     */
    public function okControllerAccess($path, $response)
    {
        $http = new HttpClient();
        $html = $http->get($this->getDocumentRootURL() . $path);
        $statusCode = $http->getStatusCode();
        $this->assertEquals($html, $response);
        $this->assertEquals($statusCode, 200);
    }

    /**
     * 異常系
     * Controllerにアクセスできず、500エラーになること
     * @test
     * @dataProvider controllerNotAccessProvider
     */
    public function ngControllerNotAccess($path, $statusCode)
    {
        $http = new HttpClient();
        $html = $http->get($this->getDocumentRootURL() . $path);
        $statusCode = $http->getStatusCode();
        $this->assertEquals($statusCode, $statusCode);
    }
}
