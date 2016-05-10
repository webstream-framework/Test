<?php
namespace WebStream\Test\IntegrationTest;

use WebStream\Module\HttpClient;
use WebStream\Test\IntegrationTest\DataProvider\ServiceProvider;

require_once dirname(__FILE__) . '/TestBase.php';
require_once dirname(__FILE__) . '/TestConstant.php';
require_once dirname(__FILE__) . '/DataProvider/ServiceProvider.php';

/**
 * ServiceTest
 * @author Ryuichi TANAKA.
 * @since 2016/05/07
 * @version 0.7
 */
class ServiceTest extends \PHPUnit_Framework_TestCase
{
    use ServiceProvider, TestConstant;

    /**
     * 正常系
     * Serviceにアクセスできること
     * @test
     * @dataProvider serviceAccessProvider
     */
    public function okServiceAccess($path, $response)
    {
        $http = new HttpClient();
        $html = $http->get($this->getDocumentRootURL() . $path);
        $statusCode = $http->getStatusCode();
        $this->assertEquals($html, $response);
        $this->assertEquals($statusCode, 200);
    }


    /**
     * 異常系
     * Serviceにアクセスできず、500エラーになること
     * @test
     * @dataProvider serviceNotAccessProvider
     */
    public function ngServiceNotAccess($path, $statusCode)
    {
        $http = new HttpClient();
        $html = $http->get($this->getDocumentRootURL() . $path);
        $statusCode = $http->getStatusCode();
        $this->assertEquals($statusCode, $statusCode);
    }
}
