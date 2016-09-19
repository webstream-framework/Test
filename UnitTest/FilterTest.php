<?php
namespace WebStream\Test\UnitTest;

use WebStream\Core\Application;
use WebStream\Core\CoreController;
use WebStream\Annotation\Filter;
use WebStream\Delegate\Router;
use WebStream\Delegate\CoreDelegator;
use WebStream\Delegate\AnnotationDelegator;
use WebStream\Module\Utility\ApplicationUtils;
use WebStream\Container\Container;
use WebStream\Http\Request;
use WebStream\Http\Response;
use WebStream\Test\UnitTest\DataProvider\FilterProvider;

require_once dirname(__FILE__) . '/TestBase.php';
require_once dirname(__FILE__) . '/DataProvider/FilterProvider.php';

/**
 * FilterTest
 * @author Ryuichi TANAKA.
 * @since 2016/01/10
 * @version 0.7
 */
class FilterTest extends \PHPUnit_Framework_TestCase
{
    use FilterProvider, ApplicationUtils;

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
     * before/afterフィルタが実行されること
     * @test
     * @dataProvider beforeAfterFilterProvider
     */
    public function okBeforeAfterFilter($path, $ca, $response)
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
                     * @Filter(type="before")
                     */
                    public function before1()
                    {
                        echo "b1";
                    }

                    /**
                     * @Filter(type="before")
                     */
                    public function before2()
                    {
                        echo "b2";
                    }

                    /**
                     * @Filter(type="after")
                     */
                    public function after1()
                    {
                        echo "a1";
                    }

                    /**
                     * @Filter(type="after")
                     */
                    public function after2()
                    {
                        echo "a2";
                    }

                    public function beforeAndAfter()
                    {
                    }
                };

                $controller->inject('request', $this->container->request)
                           ->inject('response', $this->container->response)
                           ->inject('session', $this->container->session)
                           ->inject('coreDelegator', $this->container->coreDelegator)
                           ->inject('logger', $this->container->logger);

                return $controller;
            }
        };

        $app = new Application($container);
        $app->run();

        $this->expectOutputString($response);
    }

    /**
     * 正常系
     * before/afterフィルタでexceptが実行されること
     * @test
     * @dataProvider exceptFilterProvider
     */
    public function okExceptFilter($path, $ca, $response)
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
                     * @Filter(type="before", except="beforeExceptEnable")
                     */
                    public function before()
                    {
                        echo "b";
                    }

                    /**
                     * @Filter(type="after", except="afterExceptEnable")
                     */
                    public function after()
                    {
                        echo "a";
                    }

                    public function beforeExceptEnable()
                    {
                        echo "bee";
                    }

                    public function beforeExceptDisable()
                    {
                        echo "bed";
                    }

                    public function afterExceptEnable()
                    {
                        echo "aee";
                    }

                    public function afterExceptDisable()
                    {
                        echo "aed";
                    }
                };

                $controller->inject('request', $this->container->request)
                           ->inject('response', $this->container->response)
                           ->inject('session', $this->container->session)
                           ->inject('coreDelegator', $this->container->coreDelegator)
                           ->inject('logger', $this->container->logger);

                return $controller;
            }
        };

        $app = new Application($container);
        $app->run();

        $this->expectOutputString($response);
    }

    /**
     * 正常系
     * before/afterフィルタでonlyが実行されること
     * @test
     * @dataProvider onlyFilterProvider
     */
    public function okOnlyFilter($path, $ca, $response)
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
                     * @Filter(type="before", only="beforeOnlyEnable")
                     */
                    public function before()
                    {
                        echo "b";
                    }

                    /**
                     * @Filter(type="after", only="afterOnlyEnable")
                     */
                    public function after()
                    {
                        echo "a";
                    }

                    public function beforeOnlyEnable()
                    {
                        echo "boe";
                    }

                    public function beforeOnlyDisable()
                    {
                        echo "bod";
                    }

                    public function afterOnlyEnable()
                    {
                        echo "aoe";
                    }

                    public function afterOnlyDisable()
                    {
                        echo "aod";
                    }
                };

                $controller->inject('request', $this->container->request)
                           ->inject('response', $this->container->response)
                           ->inject('session', $this->container->session)
                           ->inject('coreDelegator', $this->container->coreDelegator)
                           ->inject('logger', $this->container->logger);

                return $controller;
            }
        };

        $app = new Application($container);
        $app->run();

        $this->expectOutputString($response);
    }

    /**
     * 正常系
     * before/afterフィルタでexceptが複数実行されること
     * @test
     * @dataProvider multipleExceptFilterProvider
     */
    public function okMultipleExceptFilter($path, $ca, $response)
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
                     * @Filter(type="before", except={"beforeExceptEnable", "beforeExceptEnable2"})
                     */
                    public function before()
                    {
                        echo "b";
                    }

                    /**
                     * @Filter(type="after", except={"afterExceptEnable", "afterExceptEnable2"})
                     */
                    public function after()
                    {
                        echo "a";
                    }

                    public function beforeExceptEnable()
                    {
                        echo "bee";
                    }

                    public function beforeExceptEnable2()
                    {
                        echo "bee2";
                    }

                    public function afterExceptEnable()
                    {
                        echo "aee";
                    }

                    public function afterExceptEnable2()
                    {
                        echo "aee2";
                    }
                };

                $controller->inject('request', $this->container->request)
                           ->inject('response', $this->container->response)
                           ->inject('session', $this->container->session)
                           ->inject('coreDelegator', $this->container->coreDelegator)
                           ->inject('logger', $this->container->logger);

                return $controller;
            }
        };

        $app = new Application($container);
        $app->run();

        $this->expectOutputString($response);
    }

    /**
     * 正常系
     * before/afterフィルタでonlyが複数実行されること
     * @test
     * @dataProvider multipleOnlyFilterProvider
     */
    public function okMultipleOnlyFilter($path, $ca, $response)
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
                     * @Filter(type="before", only={"beforeOnlyEnable", "beforeOnlyEnable2"})
                     */
                    public function before()
                    {
                        echo "b";
                    }

                    /**
                     * @Filter(type="after", only={"afterOnlyEnable", "afterOnlyEnable2"})
                     */
                    public function after()
                    {
                        echo "a";
                    }

                    public function beforeOnlyEnable()
                    {
                        echo "boe";
                    }

                    public function beforeOnlyEnable2()
                    {
                        echo "boe2";
                    }

                    public function afterOnlyEnable()
                    {
                        echo "aoe";
                    }

                    public function afterOnlyEnable2()
                    {
                        echo "aoe2";
                    }
                };

                $controller->inject('request', $this->container->request)
                           ->inject('response', $this->container->response)
                           ->inject('session', $this->container->session)
                           ->inject('coreDelegator', $this->container->coreDelegator)
                           ->inject('logger', $this->container->logger);

                return $controller;
            }
        };

        $app = new Application($container);
        $app->run();

        $this->expectOutputString($response);
    }

    /**
     * 正常系
     * skipフィルタが実行されること
     * @test
     * @dataProvider skipFilterProvider
     */
    public function okSkipFilter($path, $ca, $response)
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
                     * @Filter(type="before")
                     */
                    public function before()
                    {
                        echo "b1";
                    }

                    /**
                     * @Filter(type="after")
                     */
                    public function after()
                    {
                        echo "b2";
                    }

                    /**
                     * @Filter(type="skip", except="before")
                     */
                    public function skipEnable()
                    {
                        echo "se";
                    }

                    /**
                     * @Filter(type="skip", except={"before", "after"})
                     */
                    public function multipleSkipEnable()
                    {
                        echo "mse";
                    }
                };

                $controller->inject('request', $this->container->request)
                           ->inject('response', $this->container->response)
                           ->inject('session', $this->container->session)
                           ->inject('coreDelegator', $this->container->coreDelegator)
                           ->inject('logger', $this->container->logger);

                return $controller;
            }
        };

        $app = new Application($container);
        $app->run();

        $this->expectOutputString($response);
    }

    /**
     * 正常系
     * exceptとonlyを同時に指定した場合、exceptが有効になること
     * アクションメソッド「だけ=only」でフィルタが有効になり、アクションメソッドで「除外=except」するのでexceptが有効
     * @test
     * @dataProvider exceptAndOnlyFilterProvider
     */
    public function okExceptAndOnlyFilter($path, $ca, $response)
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
                     * @Filter(type="before", except="action", only="action")
                     */
                    public function before()
                    {
                        echo "b";
                    }

                    public function action()
                    {
                        echo "a";
                    }
                };

                $controller->inject('request', $this->container->request)
                           ->inject('response', $this->container->response)
                           ->inject('session', $this->container->session)
                           ->inject('coreDelegator', $this->container->coreDelegator)
                           ->inject('logger', $this->container->logger);

                return $controller;
            }
        };

        $app = new Application($container);
        $app->run();

        $this->expectOutputString($response);
    }

    /**
     * 異常系
     * initializeフィルタを定義した場合、ステータスコードが500になること
     * @test
     * @dataProvider initializeFilterProvider
     */
    public function ngInitializeFilter($path, $ca, $response)
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
                     * @Filter(type="initialize")
                     */
                    public function initialize()
                    {
                    }

                    public function action()
                    {
                    }
                };

                $controller->inject('request', $this->container->request)
                           ->inject('response', $this->container->response)
                           ->inject('session', $this->container->session)
                           ->inject('coreDelegator', $this->container->coreDelegator)
                           ->inject('logger', $this->container->logger);

                return $controller;
            }
        };

        ob_start();
        $app = new Application($container);
        $app->run();
        $actual = ob_get_clean();

        $this->assertEquals($actual, $response);
    }
}
