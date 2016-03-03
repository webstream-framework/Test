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
use WebStream\Exception\Extend\ForbiddenAccessException;
use WebStream\Exception\Extend\SessionTimeoutException;
use WebStream\Exception\Extend\InvalidRequestException;
use WebStream\Exception\Extend\CsrfException;
use WebStream\Exception\Extend\ResourceNotFoundException;
use WebStream\Exception\Extend\ClassNotFoundException;
use WebStream\Exception\Extend\MethodNotFoundException;
use WebStream\Exception\Extend\AnnotationException;
use WebStream\Exception\Extend\RouterException;
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
                return new class($this->container) extends CoreController
                {
                    public function validateException()
                    {
                        throw new ValidateException();
                    }

                    public function forbiddenAccessException()
                    {
                        throw new ForbiddenAccessException();
                    }

                    public function sessionTimeoutException()
                    {
                        throw new SessionTimeoutException();
                    }

                    public function invalidRequestException()
                    {
                        throw new InvalidRequestException();
                    }

                    public function csrfException()
                    {
                        throw new CsrfException();
                    }

                    public function resourceNotFoundException()
                    {
                        throw new ResourceNotFoundException();
                    }

                    public function classNotFoundException()
                    {
                        throw new ClassNotFoundException();
                    }

                    public function methodNotFoundException()
                    {
                        throw new MethodNotFoundException();
                    }

                    public function annotationException()
                    {
                        throw new AnnotationException();
                    }

                    public function routerException()
                    {
                        throw new RouterException();
                    }

                    public function applicationException()
                    {
                        throw new ApplicationException();
                    }

                    /**
                     * @ExceptionHandler("WebStream\Exception\Extend\ValidateException")
                     */
                    public function validateError($params)
                    {
                        echo "validator error";
                    }

                    /**
                     * @ExceptionHandler("WebStream\Exception\Extend\ForbiddenAccessException")
                     */
                    public function forbiddenAccessError($params)
                    {
                        echo "forbidden access error";
                    }

                    /**
                     * @ExceptionHandler("WebStream\Exception\Extend\SessionTimeoutException")
                     */
                    public function sessionTimeoutError($params)
                    {
                        echo "session timeout error";
                    }

                    /**
                     * @ExceptionHandler("WebStream\Exception\Extend\InvalidRequestException")
                     */
                    public function invalidRequestError($params)
                    {
                        echo "invalid request error";
                    }

                    /**
                     * @ExceptionHandler("WebStream\Exception\Extend\CsrfException")
                     */
                    public function csrfError($params)
                    {
                        echo "csrf error";
                    }

                    /**
                     * @ExceptionHandler("WebStream\Exception\Extend\ResourceNotFoundException")
                     */
                    public function resourceNotfoundError($params)
                    {
                        echo "resource notfound error";
                    }

                    /**
                     * @ExceptionHandler("WebStream\Exception\Extend\ClassNotFoundException")
                     */
                    public function classNotFoundError($params)
                    {
                        echo "class notfound error";
                    }

                    /**
                     * @ExceptionHandler("WebStream\Exception\Extend\MethodNotFoundException")
                     */
                    public function methodNotFoundError($params)
                    {
                        echo "method notfound error";
                    }

                    /**
                     * @ExceptionHandler("WebStream\Exception\Extend\AnnotationException")
                     */
                    public function annotationError($params)
                    {
                        echo "annotation error";
                    }

                    /**
                     * @ExceptionHandler("WebStream\Exception\Extend\RouterException")
                     */
                    public function routerError($params)
                    {
                        echo "router error";
                    }

                    /**
                     * @ExceptionHandler("WebStream\Exception\Extend\ApplicationException")
                     */
                    public function applicationError($params)
                    {
                        echo "application error";
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
     *
     * @test
     * @dataProvider excecptionProvider
     */
    public function okExcecptionHandler($path, $ca, $response)
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

}
