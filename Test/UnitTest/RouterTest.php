<?php
namespace WebStream\Test\UnitTest;

use WebStream\Test\TestBase;
use WebStream\Test\TestConstant;
use WebStream\Delegate\Router;
use WebStream\Module\Utility\ApplicationUtils;
use WebStream\Module\Container;
use WebStream\Http\Request;
use WebStream\Test\DataProvider\RouterProvider;
use WebStream\Test\DataProvider\RouterProvider2;

require_once dirname(__FILE__) . '/../TestBase.php';
require_once 'DataProvider/RouterProvider.php';

/**
 * Routerクラスのテストクラス
 * @author Ryuichi TANAKA.
 * @since 2011/09/21
 * @version 0.7
 */
class RouterTest extends TestBase
{
    use RouterProvider, TestConstant;
    use ApplicationUtils;

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
    }

    private function getRequestContainer($pathInfo)
    {
        $requestContainer = new Container(false);
        $requestContainer->pathInfo = $pathInfo;
        $request = new Request();
        $request->inject('logger', new class() { function __call($name, $args) {} })
                ->inject('container', $requestContainer);

        return $request->getContainer();
    }

    private function getRouterContainer(array $routingRule, Container $requestContainer)
    {
        $applicationRoot = $this->getApplicationRoot();
        $appContainer = function() use ($applicationRoot) {
            $info = new Container();
            $info->applicationRoot = $applicationRoot;
            $info->applicationDir = "app";
            $info->sharedDir = "_shared";
            $info->publicDir = "_public";
            $info->cacheDir = "_cache";
            $info->cachePrefix = "webstream-cache-";

            return $info;
        };

        $router = new Router($routingRule, $requestContainer);
        $router->inject('logger', new class() { function __call($name, $args) {}})
               ->inject('applicationInfo', $appContainer);
        $router->resolve();

        return $router->getRoutingResult();
    }

    /**
     * 正常系
     * プレースホルダなしのパスに対して名前解決できること
     * @test
     * @dataProvider resolveRoutingProvider
     */
    public function okResolveRouting($uri, $ca, $controller, $action)
    {
        $requestContainer = $this->getRequestContainer($uri);
        $routerContainer = $this->getRouterContainer([$uri => $ca], $requestContainer);

        $this->assertEquals($routerContainer->controller, $controller);
        $this->assertEquals($routerContainer->action, $action);
    }

    /**
     * 正常系
     * プレースホルダありのパスに対して名前解決できること
     * @test
     * @dataProvider resolveRoutingPlaceholderProvider
     */
    public function okResolveRoutingPlaceholder($defineUri, $actualUri, $ca, $controller, $action, $placeholderKey, $paramValue)
    {
        $requestContainer = $this->getRequestContainer($actualUri);
        $routerContainer = $this->getRouterContainer([$defineUri => $ca], $requestContainer);

        $this->assertEquals($routerContainer->controller, $controller);
        $this->assertEquals($routerContainer->action, $action);
        $this->assertEquals($routerContainer->params[$placeholderKey], $paramValue);
    }

    /**
     * 異常系
     * 名前解決に失敗する場合、例外が発生すること
     * @test
     * @dataProvider unResolveRoutingProvider
     * @expectedException WebStream\Exception\Extend\RouterException
     */
    public function ngUnResolveRouting($uri, $ca)
    {
        $requestContainer = $this->getRequestContainer($uri);
        $routerContainer = $this->getRouterContainer([$uri => $ca], $requestContainer);
        $this->assertTrue(false);
    }
}
