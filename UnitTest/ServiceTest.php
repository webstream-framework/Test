<?php
namespace WebStream\Test\UnitTest;

use WebStream\Core\Application;
use WebStream\Core\CoreController;
use WebStream\Core\CoreService;
use WebStream\Delegate\Router;
use WebStream\Delegate\CoreDelegator;
use WebStream\Delegate\AnnotationDelegator;
use WebStream\Module\Utility\ApplicationUtils;
use WebStream\Container\Container;
use WebStream\Http\Request;
use WebStream\Http\Response;
use WebStream\Test\UnitTest\DataProvider\ServiceProvider;

require_once dirname(__FILE__) . '/TestBase.php';
require_once dirname(__FILE__) . '/DataProvider/ServiceProvider.php';

/**
 * ServiceTest
 * @author Ryuichi TANAKA.
 * @since 2016/01/07
 * @version 0.7
 */
class ServiceTest extends \PHPUnit_Framework_TestCase
{
    use ServiceProvider, ApplicationUtils;

    public function setUp()
    {
        parent::setUp();
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
        return new class() {
            public function __call($name, $args) {}
            public function move($statusCode) {
                echo $statusCode;
            }
        };
    }

    private function getStaticFileResponse()
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
        return new class($container) extends CoreDelegator
        {
            private $container;
            public function __construct($container)
            {
                parent::__construct($container);
                $this->container = $container;
            }

            public function getController()
            {
                $controller =  new class() extends CoreController
                {
                    public function testFoundService()
                    {
                        $this->UnitTest->foundService();
                    }

                    public function testFoundServiceAndFoundModel()
                    {
                        $this->UnitTest->foundServiceAndFoundModel();
                    }

                    public function testNotfoundServiceAndFoundModel()
                    {
                        $this->UnitTest->notfoundServiceAndFoundModel();
                    }

                    public function testServiceAndNotfoundModel()
                    {
                        $this->UnitTest->notfoundModel();
                    }

                    public function testNotfoundServiceAndModel()
                    {
                        $this->UnitTest->notfound();
                    }

                    public function testNotfoundServiceAndFoundModelArgument()
                    {
                        $this->UnitTest->notfoundServiceAndFoundModelArgument("m");
                    }
                };

                $controller->inject('request', $this->container->request)
                           ->inject('response', $this->container->response)
                           ->inject('session', $this->container->session)
                           ->inject('coreDelegator', $this->container->coreDelegator)
                           ->inject('logger', $this->container->logger);

                return $controller;
            }

            public function getService()
            {
                $service = new class() extends CoreService
                {
                    public function foundService()
                    {
                        echo "s";
                    }

                    public function foundServiceAndFoundModel()
                    {
                        echo "s";
                        $this->UnitTest->foundServiceAndFoundModel();
                    }

                    public function notfoundModel()
                    {
                        $this->UnitTest->notfoundModel();
                    }
                };

                $service->inject('coreDelegator', $this->container->coreDelegator)
                        ->inject('logger', $this->container->logger);

                return $service;
            }

            public function getModel()
            {
                return new class()
                {
                    public function run($method, $args)
                    {
                        if (count($args) > 0) {
                            $this->{$method}($args[0]);
                        } else {
                            $this->{$method}();
                        }
                    }

                    public function notfoundServiceAndFoundModel()
                    {
                        echo "m";
                    }

                    public function foundServiceAndFoundModel()
                    {
                        echo "m";
                    }

                    public function notfoundServiceAndFoundModelArgument($arg)
                    {
                        echo $arg;
                    }
                };
            }
        };
    }

    private function getCoreDelegator2(Container $container)
    {
        return new class($container) extends CoreDelegator
        {
            private $container;
            public function __construct($container)
            {
                parent::__construct($container);
                $this->container = $container;
            }

            public function getController()
            {
                $controller = new class() extends CoreController
                {
                    public function action()
                    {
                        $this->UnitTest->serviceAction();
                    }
                };

                $controller->inject('request', $this->container->request)
                           ->inject('response', $this->container->response)
                           ->inject('session', $this->container->session)
                           ->inject('coreDelegator', $this->container->coreDelegator)
                           ->inject('logger', $this->container->logger);

                return $controller;
            }

            public function getService()
            {
                $service = new class() extends CoreService
                {
                    public function serviceAction()
                    {
                        echo get_class($this->UnitTest);
                        $this->UnitTest->modelAction();
                    }
                };

                $service->inject('coreDelegator', $this->container->coreDelegator)
                        ->inject('logger', $this->container->logger);

                return $service;
            }
        };
    }

    private function getAnnotationDelegator(Container $container)
    {
        return new AnnotationDelegator($container);
    }

    /**
     * 正常系
     * Serviceにアクセスできること
     * @test
     * @dataProvider runServiceProvider
     */
    public function okRunService($path, $ca, $response)
    {
        $container = new Container();
        $container->request = $this->getRequest($path);
        $container->router = $this->getRouter([$path => $ca], $container->request);
        $container->response = $this->getResponse();
        $container->session = $this->getSession();
        $container->logger = $this->getLogger();
        $container->applicationInfo = $this->getApplicationInfo();
        $container->coreDelegator = $this->getCoreDelegator($container);
        $container->annotationDelegator = $this->getAnnotationDelegator($container);

        $app = new Application($container);
        $app->run();

        $this->expectOutputString($response);
    }

    /**
     * 正常系
     * ServiceからModelにアクセスできること
     * @test
     * @dataProvider runServiceAndModelProvider
     */
    public function okRunServiceAndModel($path, $ca, $response)
    {
        $container = new Container();
        $container->request = $this->getRequest($path);
        $container->router = $this->getRouter([$path => $ca], $container->request);
        $container->response = $this->getResponse();
        $container->session = $this->getSession();
        $container->logger = $this->getLogger();
        $container->applicationInfo = $this->getApplicationInfo();
        $container->coreDelegator = $this->getCoreDelegator($container);
        $container->annotationDelegator = $this->getAnnotationDelegator($container);

        $app = new Application($container);
        $app->run();

        $this->expectOutputString($response);
    }

    /**
     * 正常系
     * 存在しないServiceにアクセスした場合、Modelにアクセスできること
     * @test
     * @dataProvider notRunServiceAndRunModelProvider
     */
    public function okNotRunServiceAndRunModel($path, $ca, $response)
    {
        $container = new Container();
        $container->request = $this->getRequest($path);
        $container->router = $this->getRouter([$path => $ca], $container->request);
        $container->response = $this->getResponse();
        $container->session = $this->getSession();
        $container->logger = $this->getLogger();
        $container->applicationInfo = $this->getApplicationInfo();
        $container->coreDelegator = $this->getCoreDelegator($container);
        $container->annotationDelegator = $this->getAnnotationDelegator($container);

        $app = new Application($container);
        $app->run();

        $this->expectOutputString($response);
    }

    /**
     * 異常系
     * Serviceから存在しないModelにアクセスした場合、
     * ModelオブジェクトはWebStream\Delegate\CoreExceptionDelegatorで、ステータスコードが500になること
     * @test
     * @dataProvider notRunModelProvider
     */
    public function ngNotRunModel($path, $ca, $response)
    {
        $container = new Container();
        $container->request = $this->getRequest($path);
        $container->router = $this->getRouter([$path => $ca], $container->request);
        $container->response = $this->getResponse();
        $container->session = $this->getSession();
        $container->logger = $this->getLogger();
        $container->applicationInfo = $this->getApplicationInfo();
        $container->coreDelegator = $this->getCoreDelegator2($container);
        $container->annotationDelegator = $this->getAnnotationDelegator($container);

        ob_start();
        $app = new Application($container);
        $app->run();
        $actual = ob_get_clean();

        $this->assertEquals($actual, $response);
    }
}
