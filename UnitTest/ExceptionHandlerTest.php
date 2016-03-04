<?php
namespace WebStream\Test\UnitTest;

use WebStream\Core\Application;
use WebStream\Core\CoreController;
use WebStream\Delegate\Router;
use WebStream\Delegate\CoreDelegator;
use WebStream\Delegate\AnnotationDelegator;
use WebStream\Module\Utility\ApplicationUtils;
use WebStream\Module\Container;
use WebStream\Http\Request;
use WebStream\Http\Response;
use WebStream\Annotation\ExceptionHandler;
use WebStream\Exception\ApplicationException;
use WebStream\Exception\Extend\ValidateException;
use WebStream\Exception\Extend\IOException;
use WebStream\Test\UnitTest\DataProvider\ExceptionHandlerProvider;

require_once dirname(__FILE__) . '/TestBase.php';
require_once dirname(__FILE__) . '/DataProvider/ExceptionHandlerProvider.php';

/**
 * ExceptionHandlerTest
 * @author Ryuichi TANAKA.
 * @since 2016/03/03
 * @version 0.7
 */
class ExceptionHandlerTest extends \PHPUnit_Framework_TestCase
{
    use ExceptionHandlerProvider, ApplicationUtils;

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
        return new class() {
            public function __call($name, $args) {}
            public function displayFile($filename) {
                echo $filename;
            }
        };
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

    private function getCoreDelegator1(Container $container)
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
                return new class($this->container) extends CoreController
                {
                    public function exceptionAction()
                    {
                        throw new ApplicationException("message");
                    }

                    /**
                     * @ExceptionHandler("WebStream\Exception\ApplicationException")
                     */
                    public function error($params)
                    {
                        echo $params["method"];
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
                return new class($this->container) extends CoreController
                {
                    public function exceptionAction()
                    {
                        throw new ValidateException();
                    }

                    /**
                     * @ExceptionHandler("WebStream\Exception\ApplicationException")
                     */
                    public function error($params)
                    {
                        echo $params["method"];
                    }
                };
            }
        };
    }

    private function getCoreDelegator3(Container $container)
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
                return new class($this->container) extends CoreController
                {
                    public function exceptionAction1()
                    {
                        throw new ValidateException();
                    }

                    public function exceptionAction2()
                    {
                        throw new IOException();
                    }

                    /**
                     * @ExceptionHandler("WebStream\Exception\Extend\ValidateException")
                     * @ExceptionHandler("WebStream\Exception\Extend\IOException")
                     */
                    public function error($params)
                    {
                        echo $params["method"];
                    }
                };
            }
        };
    }

    private function getCoreDelegator4(Container $container)
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
                return new class($this->container) extends CoreController
                {
                    public function exceptionAction1()
                    {
                        throw new ValidateException();
                    }

                    public function exceptionAction2()
                    {
                        throw new IOException();
                    }

                    /**
                     * @ExceptionHandler({"WebStream\Exception\Extend\ValidateException", "WebStream\Exception\Extend\IOException"})
                     */
                    public function error($params)
                    {
                        echo $params["method"];
                    }
                };
            }
        };
    }

    private function getAnnotationDelegator(Container $container)
    {
        return new AnnotationDelegator($container);
    }

    /**
     * 正常系
     * 発生した例外を捕捉できること
     * @test
     * @dataProvider excecptionProvider
     */
    public function okExcecptionHandler($no, $path, $ca, $response)
    {
        $container = new Container();
        $container->request = $this->getRequest($path);
        $container->router = $this->getRouter([$path => $ca], $container->request);
        $container->response = $this->getResponse();
        $container->session = $this->getSession();
        $container->logger = $this->getLogger();
        $container->applicationInfo = $this->getApplicationInfo();
        $coreDelegatorMethodName = "getCoreDelegator" . $no;
        $container->coreDelegator = $this->{$coreDelegatorMethodName}($container);
        $container->annotationDelegator = $this->getAnnotationDelegator($container);

        $app = new Application($container);
        $app->run();

        $this->expectOutputString($response);
    }
}
