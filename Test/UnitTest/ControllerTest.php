<?php
namespace WebStream\Test\UnitTest;

use WebStream\Test\TestBase;
use WebStream\Test\TestConstant;
use WebStream\Core\Application;
use WebStream\Delegate\Router;
use WebStream\Delegate\CoreDelegator;
use WebStream\Delegate\AnnotationDelegator;
use WebStream\Module\Utility\ApplicationUtils;
use WebStream\Module\Container;
use WebStream\Http\Request;
use WebStream\Test\DataProvider\RouterProvider;

require_once dirname(__FILE__) . '/../TestBase.php';
require_once 'DataProvider/RouterProvider.php';

/**
 * Controller Test
 * @author Ryuichi TANAKA.
 * @since 2016/01/02
 * @version 0.7
 */
class ControllerTest extends TestBase
{
    use ApplicationUtils;

    public function setUp()
    {
        parent::setUp();



    }

    public function tearDown()
    {
    }

    private function getLogger()
    {
        return new class() { function __call($name, $args) {} };
    }

    private function getRequest($pathInfo)
    {
        $requestContainer = new Container(false);
        $requestContainer->pathInfo = $pathInfo;
        $request = new Request();
        $request->inject('logger', $this->getLogger())
                ->inject('container', $requestContainer);

        return $request->getContainer();
    }

    private function getRouter(array $routingRule, Container $requestContainer)
    {
        $router = new Router($routingRule, $requestContainer);
        $router->inject('logger', $this->getLogger())
               ->inject('applicationInfo', $this->getApplicationInfo());
        $router->resolve();

        return $router->getRoutingResult();
    }

    private function getResponse()
    {
        return new class() { function __call($name, $args) {} };
    }

    private function getSession()
    {
        return new class() { function __call($name, $args) {} };
    }

    private function getApplicationInfo()
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

        return $appContainer;
    }

    private function getCoreDelegator(Container $container)
    {
        return new CoreDelegator($container);
    }

    private function getAnnotationDelegator(Container $container)
    {
        return new AnnotationDelegator($container);
    }

    /**
     * 正常系
     *
     * @test
     */
    public function okHoge()
    {
        $container = new Container();
        $container->request = $this->getRequest("/");
        $container->response = $this->getResponse();
        $container->session = $this->getSession();
        $container->router = $this->getRouter(["/" => "test#test1"], $container->request);
        $container->logger = $this->getLogger();
        $container->applicationInfo = $this->getApplicationInfo();
        $container->coreDelegator = $this->getCoreDelegator($container);
        $container->annotationDelegator = $this->getAnnotationDelegator($container);

        $app = new Application($container);
        $app->run();

        $this->expectOutputString('test1');
    }

}
