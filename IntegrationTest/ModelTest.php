<?php
namespace WebStream\Test\IntegrationTest;

use WebStream\Module\HttpClient;
use WebStream\Test\IntegrationTest\DataProvider\ModelProvider;

require_once dirname(__FILE__) . '/TestBase.php';
require_once dirname(__FILE__) . '/TestConstant.php';
require_once dirname(__FILE__) . '/DataProvider/ModelProvider.php';

/**
 * ModelTest
 * @author Ryuichi TANAKA.
 * @since 2016/05/07
 * @version 0.7
 */
class ModelTest extends \PHPUnit_Framework_TestCase
{
    use ModelProvider, TestConstant;

    /**
     * 正常系
     * Modelにアクセスできること
     * @test
     * @dataProvider modelAccessProvider
     */
    public function okModelAccess($path, $response)
    {
        $http = new HttpClient();
        $html = $http->get($this->getDocumentRootURL() . $path);
        $statusCode = $http->getStatusCode();
        $this->assertEquals($html, $response);
        $this->assertEquals($statusCode, 200);
    }

    /**
     * 異常系
     * Modelにアクセスできず、エラーになること
     * @test
     * @dataProvider modelNotAccessProvider
     */
    public function ngModelNotAccess($path, $errorMessage)
    {
        $http = new HttpClient();
        $html = $http->get($this->getDocumentRootURL() . $path);
        $this->assertTrue(strpos($html, $errorMessage) !== false);
    }
}
