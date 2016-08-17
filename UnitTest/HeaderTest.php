<?php
namespace WebStream\Test\UnitTest;

use WebStream\Core\Application;
use WebStream\Core\CoreController;
use WebStream\Annotation\Header;
use WebStream\Delegate\Router;
use WebStream\Delegate\CoreDelegator;
use WebStream\Delegate\AnnotationDelegator;
use WebStream\Module\Utility\ApplicationUtils;
use WebStream\Module\Container;
use WebStream\Http\Request;
use WebStream\Http\Response;
use WebStream\Test\UnitTest\DataProvider\HeaderProvider;

require_once dirname(__FILE__) . '/TestBase.php';
require_once dirname(__FILE__) . '/DataProvider/HeaderProvider.php';

/**
 * HeaderTest
 * @author Ryuichi TANAKA.
 * @since 2016/01/17
 * @version 0.7
 */
class HeaderTest extends \PHPUnit_Framework_TestCase
{
    use HeaderProvider, ApplicationUtils;

    public function setUp()
    {
        parent::setUp();
    }

    private function getLogger()
    {
        return new class() { function __call($name, $args) {} };
    }

    private function getRequest($pathInfo, $requestMethod = "get")
    {
        $requestContainer = new Container(false);
        $requestContainer->pathInfo = $pathInfo;
        $requestContainer->requestMethod = $requestMethod;
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

    private function getContentTypeResponse()
    {
        $response = new class() extends Response
        {
            public function header() {}
            public function body() {}
            public function start() {}
            public function end() {}
            public function setType($fileType)
            {
                if (array_key_exists($fileType, $this->mime)) {
                    echo $this->mime[$fileType];
                }
                else {
                    echo $this->mime['file'];
                }
            }

            public function move($statusCode) {
                echo $statusCode;
            }
        };
        $response->inject('logger', $this->getLogger());

        return $response;
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
                $controller = new class() extends CoreController
                {
                    /**
                     * @Header(allowMethod="get")
                     */
                    public function allowGet1()
                    {
                        echo "g";
                    }

                    /**
                     * @Header(allowMethod="GET")
                     */
                    public function allowGet2()
                    {
                        echo "g";
                    }

                    /**
                     * @Header(allowMethod="post")
                     */
                    public function allowPost1()
                    {
                        echo "p";
                    }

                    /**
                     * @Header(allowMethod="POST")
                     */
                    public function allowPost2()
                    {
                        echo "p";
                    }

                    /**
                     * @Header(allowMethod={"GET","POST"})
                     */
                    public function allowGetPost()
                    {
                        echo "gp";
                    }

                    /**
                     * @Header(contentType="xml", allowMethod="POST")
                     */
                    public function allowXmlGet()
                    {
                    }

                    public function __call($name, $args) {}
                };

                $controller->inject('request', $this->container->request)
                           ->inject('response', $this->container->response)
                           ->inject('session', $this->container->session)
                           ->inject('coreDelegator', $this->container->coreDelegator)
                           ->inject('logger', $this->container->logger);

                return $controller;
            }
        };
    }

    private function getAnnotationDelegator(Container $container)
    {
        return new AnnotationDelegator($container);
    }

    /**
     * 正常系
     * 適切なContent-Typeが出力されること
     * @test
     * @dataProvider runDisplayHeaderProvider
     */
    public function okRunDisplayHeader($filename, $contentType)
    {
        $container = new Container();
        $container->request = $this->getRequest($filename);

        $routingContainer = new Container(false);
        $routingContainer->staticFile = $filename;
        $router = new Router([], $container->request);
        $router->inject('logger', $this->getLogger())
               ->inject('applicationInfo', $this->getApplicationInfo())
               ->inject('routingContainer', $routingContainer);
        $router->resolve();

        $container->router = $router->getRoutingResult();
        $container->response = $this->getContentTypeResponse();
        $container->session = $this->getSession();
        $container->logger = $this->getLogger();
        $container->applicationInfo = $this->getApplicationInfo();
        $container->coreDelegator = $this->getCoreDelegator($container);
        $container->annotationDelegator = $this->getAnnotationDelegator($container);

        $app = new Application($container);
        $app->run();

        $this->expectOutputString($contentType);
    }

    /**
     * 正常系
     * allowMethodで指定したメソッドでアクセスできること
     * @test
     * @dataProvider runAllowMethodProvider
     */
    public function okRunAllowMethod($path, $ca, $requestMethod, $response)
    {
        $container = new Container();
        $container->request = $this->getRequest($path, $requestMethod);
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
     * allowMethodで指定したメソッドに指定したContentTypeでアクセスできること
     * @test
     * @dataProvider runContentTypeAndAllowMethodProvider
     */
    public function okRunContentTypeAndAllowMethod($filename, $contentType, $requestMethod)
    {
        $container = new Container();
        $container->request = $this->getRequest($filename, $requestMethod);

        $routingContainer = new Container(false);
        $routingContainer->staticFile = $filename;
        $router = new Router([], $container->request);
        $router->inject('logger', $this->getLogger())
               ->inject('applicationInfo', $this->getApplicationInfo())
               ->inject('routingContainer', $routingContainer);
        $router->resolve();

        $container->router = $router->getRoutingResult();
        $container->response = $this->getContentTypeResponse();
        $container->session = $this->getSession();
        $container->logger = $this->getLogger();
        $container->applicationInfo = $this->getApplicationInfo();
        $container->coreDelegator = $this->getCoreDelegator($container);
        $container->annotationDelegator = $this->getAnnotationDelegator($container);

        $app = new Application($container);
        $app->run();

        $this->expectOutputString($contentType);
    }

    /**
     * 異常系
     * allowMethodで指定したメソッド以外ではアクセスできないこと
     * @test
     * @dataProvider runNotAllowMethodProvider
     */
    public function ngRunNotRunAllowMethod($path, $ca, $requestMethod, $response)
    {
        $container = new Container();
        $container->request = $this->getRequest($path, $requestMethod);
        $container->router = $this->getRouter([$path => $ca], $container->request);
        $container->response = $this->getResponse();
        $container->session = $this->getSession();
        $container->logger = $this->getLogger();
        $container->applicationInfo = $this->getApplicationInfo();
        $container->coreDelegator = $this->getCoreDelegator($container);
        $container->annotationDelegator = $this->getAnnotationDelegator($container);

        ob_start();
        $app = new Application($container);
        $app->run();
        $actual = ob_get_clean();

        $this->assertEquals($actual, $response);
    }
}
