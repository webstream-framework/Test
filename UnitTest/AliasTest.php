<?php
namespace WebStream\Test\UnitTest;

use WebStream\Core\Application;
use WebStream\Core\CoreController;
use WebStream\Core\CoreService;
use WebStream\Core\CoreModel;
use WebStream\Database\DatabaseManager;
use WebStream\Annotation\Alias;
use WebStream\Delegate\Router;
use WebStream\Delegate\CoreDelegator;
use WebStream\Delegate\AnnotationDelegator;
use WebStream\Module\Utility\ApplicationUtils;
use WebStream\Container\Container;
use WebStream\Http\Request;
use WebStream\Http\Response;
use WebStream\Test\UnitTest\DataProvider\AliasProvider;

require_once dirname(__FILE__) . '/TestBase.php';
require_once dirname(__FILE__) . '/DataProvider/AliasProvider.php';

/**
 * AliasTest
 * @author Ryuichi TANAKA.
 * @since 2016/01/11
 * @version 0.7
 */
class AliasTest extends \PHPUnit_Framework_TestCase
{
    use AliasProvider, ApplicationUtils;

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
            public function move($statusCode)
            {
                echo $statusCode;
            }
        };
    }

    private function getStaticFileResponse()
    {
        return new class() {
            public function __call($name, $args) {}
            public function displayFile($filename)
            {
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

    private function getAnnotationDelegator(Container $container)
    {
        return new AnnotationDelegator($container);
    }

    /**
     * 正常系
     * エイリアス経由で実メソッドにアクセスできること
     * @test
     * @dataProvider aliasAccessProvider
     */
    public function okAliasAccess($path, $ca, $response)
    {
        $container = new Container();
        $container->request = $this->getRequest($path);
        $container->router = $this->getRouter([$path => $ca], $container->request);
        $container->response = $this->getResponse();
        $container->session = $this->getSession();
        $container->logger = $this->getLogger();
        $container->applicationInfo = $this->getApplicationInfo();
        $container->annotationDelegator = $this->getAnnotationDelegator($container);

        $container->coreDelegator = new class($container) extends CoreDelegator
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
                     * @Alias(name="aliasMethod1")
                     */
                    public function originMethod1()
                    {
                        echo "originMethod1";
                    }

                    /**
                     * @Alias(name="aliasMethod2")
                     */
                    public function originMethod2()
                    {
                        $this->UnitTest->aliasMethod2();
                    }

                    /**
                     * @Alias(name="aliasMethod3")
                     */
                    public function originMethod3()
                    {
                        $this->UnitTest->aliasMethod3();
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
                $service = new class($this->container) extends CoreService
                {
                    /**
                     * @Alias(name="aliasMethod2")
                     */
                    public function originMethod2()
                    {
                        echo "originMethod2";
                    }
                };

                $service->inject('coreDelegator', $this->container->coreDelegator)
                        ->inject('logger', $this->container->logger);

                return $service;
            }

            public function getModel()
            {
                $model = new class() extends CoreModel
                {
                    /**
                     * @Alias(name="aliasMethod3")
                     */
                    public function originMethod3()
                    {
                        echo "originMethod3";
                    }
                };

                $model->inject('logger', $this->container->logger);

                return $model;
            }
        };

        $app = new Application($container);
        $app->run();

        $this->expectOutputString($response);
    }

    /**
     * 正常系
     * エイリアス定義されたメソッドが実メソッドとしてすでに存在する場合、実メソッドアクセスになること
     * @test
     * @dataProvider originAccessProvider
     */
    public function okOriginAccess($path, $ca, $response)
    {
        $container = new Container();
        $container->request = $this->getRequest($path);
        $container->router = $this->getRouter([$path => $ca], $container->request);
        $container->response = $this->getResponse();
        $container->session = $this->getSession();
        $container->logger = $this->getLogger();
        $container->applicationInfo = $this->getApplicationInfo();
        $container->annotationDelegator = $this->getAnnotationDelegator($container);

        $container->coreDelegator = new class($container) extends CoreDelegator
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
                     * @Alias(name="aliasMethod1")
                     */
                    public function originMethod1()
                    {
                        // 決して呼ばれない
                    }

                    public function aliasMethod1()
                    {
                        echo "originMethod1";
                    }

                    /**
                     * @Alias(name="aliasMethod2")
                     */
                    public function originMethod2()
                    {
                        $this->UnitTest->aliasMethod2();
                    }

                    /**
                     * @Alias(name="aliasMethod3")
                     */
                    public function originMethod3()
                    {
                        $this->UnitTest->aliasMethod3();
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
                $service = new class($this->container) extends CoreService
                {
                    /**
                     * @Alias(name="aliasMethod2")
                     */
                    public function originMethod2()
                    {
                        // 決して呼ばれない
                    }

                    public function aliasMethod2()
                    {
                        echo "originMethod2";
                    }
                };

                $service->inject('coreDelegator', $this->container->coreDelegator)
                        ->inject('logger', $this->container->logger);

                return $service;
            }

            public function getModel()
            {
                $model = new class() extends CoreModel
                {
                    /**
                     * @Alias(name="aliasMethod3")
                     */
                    public function originMethod3()
                    {
                        // 決して呼ばれない
                    }

                    public function aliasMethod3()
                    {
                        echo "originMethod3";
                    }
                };

                $model->inject('logger', $this->container->logger);

                return $model;
            }
        };

        $app = new Application($container);
        $app->run();

        $this->expectOutputString($response);
    }

    /**
     * 異常系
     * エイリアスメソッド名が不正な場合、例外が発生すること
     * @test
     * @dataProvider aliasAccessErrorProvider
     */
    public function ngAliasAccess($path, $ca)
    {
        $container = new Container();
        $container->request = $this->getRequest($path);
        $container->router = $this->getRouter([$path => $ca], $container->request);
        $container->response = $this->getResponse();
        $container->session = $this->getSession();
        $container->logger = $this->getLogger();
        $container->applicationInfo = $this->getApplicationInfo();
        $container->annotationDelegator = $this->getAnnotationDelegator($container);

        $container->coreDelegator = new class($container) extends CoreDelegator
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
                     * @Alias(name="12345")
                     */
                    public function originMethod1()
                    {
                    }

                    public function originMethod2()
                    {
                        $this->UnitTest->originMethod2();
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
                $service = new class($this->container) extends CoreService
                {
                    /**
                     * @Alias(name="12345")
                     */
                    public function originMethod2()
                    {
                    }

                    public function originMethod3()
                    {
                        $this->UnitTest->originMethod3();
                    }
                };

                $service->inject('coreDelegator', $this->container->coreDelegator)
                        ->inject('logger', $this->container->logger);

                return $service;
            }

            public function getModel()
            {
                $model = new class() extends CoreModel
                {
                    /**
                     * @Alias(name="12345")
                     */
                    public function originMethod3()
                    {
                    }
                };

                $model->inject('logger', $this->container->logger);

                return $model;
            }
        };

        ob_start();
        $app = new Application($container);
        $app->run();
        $actual = ob_get_clean();

        $this->assertEquals($actual, 500);
    }
}
