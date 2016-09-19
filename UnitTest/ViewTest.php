<?php
namespace WebStream\Test\UnitTest;

use WebStream\Core\Application;
use WebStream\Core\CoreController;
use WebStream\Core\CoreView;
use WebStream\Annotation\Header;
use WebStream\Annotation\Template;
use WebStream\Delegate\Router;
use WebStream\Delegate\CoreDelegator;
use WebStream\Delegate\AnnotationDelegator;
use WebStream\Module\Utility\ApplicationUtils;
use WebStream\Container\Container;
use WebStream\Http\Request;
use WebStream\Http\Response;
use WebStream\Template\Basic;
use WebStream\Test\UnitTest\DataProvider\ViewProvider;

require_once dirname(__FILE__) . '/TestBase.php';
require_once dirname(__FILE__) . '/DataProvider/ViewProvider.php';

/**
 * ViewTest
 * @author Ryuichi TANAKA.
 * @since 2016/01/07
 * @version 0.7
 */
class ViewTest extends \PHPUnit_Framework_TestCase
{
    use ViewProvider, ApplicationUtils;

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
            public function move($statusCode) {}
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
                $controller = new class() extends CoreController
                {
                    /**
                     * @Template("test.tmpl")
                     */
                    public function testFoundView()
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

            public function getView()
            {
                return new class($this->container) extends CoreView
                {
                    public function draw(array $params)
                    {
                        $container = new Container(false);
                        $templateEngine = new class($container) extends Basic
                        {
                            public function render(array $params)
                            {
                                // 実際はここでテンプレートが描画される
                                echo "v";
                            }
                        };

                        $templateEngine->render($params);
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
     * Viewテンプレートにアクセスできること
     * @test
     * @dataProvider runViewTemplateProvider
     */
    public function okRunViewTemplate($path, $ca, $response)
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
