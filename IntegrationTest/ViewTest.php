<?php
namespace WebStream\Test\IntegrationTest;

use WebStream\Module\HttpClient;
use WebStream\Test\IntegrationTest\DataProvider\ViewProvider;

require_once dirname(__FILE__) . '/TestBase.php';
require_once dirname(__FILE__) . '/TestConstant.php';
require_once dirname(__FILE__) . '/DataProvider/ViewProvider.php';

/**
 * ViewTest
 * @author Ryuichi TANAKA.
 * @since 2016/06/10
 * @version 0.7
 */
class ViewTest extends \PHPUnit_Framework_TestCase
{
    use ViewProvider, TestConstant;

    /**
     * 正常系
     * Viewにアクセスできること
     * @test
     * @dataProvider viewAccessProvider
     */
    public function okViewAccess($path, $response)
    {
        $http = new HttpClient();
        $html = $http->get($this->getDocumentRootURL() . $path);
        $statusCode = $http->getStatusCode();
        $this->assertEquals($html, $response);
        $this->assertEquals($statusCode, 200);
    }
}
