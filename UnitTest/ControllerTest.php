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
use WebStream\Test\UnitTest\DataProvider\ControllerProvider;

require_once dirname(__FILE__) . '/TestBase.php';
require_once dirname(__FILE__) . '/DataProvider/ControllerProvider.php';

/**
 * ControllerTest
 * @author Ryuichi TANAKA.
 * @since 2016/01/02
 * @version 0.7
 */
class ControllerTest extends \PHPUnit_Framework_TestCase
{
    use ControllerProvider, ApplicationUtils;

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
                    public function foundController()
                    {
                        echo "c";
                    }

                    public function testParam(array $params)
                    {
                        echo $params['id'];
                    }

                    public function testGet()
                    {
                        echo $this->request->get['name'];
                    }

                    public function testPost()
                    {
                        echo $this->request->post['name'];
                    }

                    public function testPut()
                    {
                        echo $this->request->put['name'];
                    }

                    public function testNotfoundServiceAndNotfoundModel()
                    {
                        echo get_class($this->UnitTest);
                        $this->UnitTest->testNotfoundServiceAndNotfoundModel();
                    }

                    public function __call($name, $args) {}
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
     * Controllerにアクセスできること
     * @test
     * @dataProvider runControllerProvider
     */
    public function okRunController($path, $ca, $response)
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
     * プレースホルダ付きパスに対してControllerにアクセスできること
     * さらにパラメータとして取得できること
     * @test
     * @dataProvider runControllerPlaceholderParameterProvider
     */
    public function okRunControllerPlaceholderParameter($routingPath, $actualPath, $ca, $response)
    {
        $container = new Container();
        $container->request = $this->getRequest($actualPath);
        $container->router = $this->getRouter([$routingPath => $ca], $container->request);
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
     * GET/POST/PUTパラメータ付きでControllerにアクセスできること
     * さらにパラメータとして取得できること
     * @test
     * @dataProvider runControllerRequestParameterProvider
     */
    public function okRunControllerRequestParameter($httpMethod, $path, $ca, $key, $value)
    {
        $container = new Container();
        $container->request = $this->getRequest($path);
        $container->request->{$httpMethod} = [$key => $value];
        $container->router = $this->getRouter([$path => $ca], $container->request);
        $container->response = $this->getResponse();
        $container->session = $this->getSession();
        $container->logger = $this->getLogger();
        $container->applicationInfo = $this->getApplicationInfo();
        $container->coreDelegator = $this->getCoreDelegator($container);
        $container->annotationDelegator = $this->getAnnotationDelegator($container);

        $app = new Application($container);
        $app->run();

        $this->expectOutputString($value);
    }

    /**
     * 正常系
     * 静的ファイルはルーティング不要で出力されること
     * @test
     * @dataProvider runControllerStaticFileProvider
     */
    public function okRunControllerStaticFile($filename)
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
        $container->response = $this->getStaticFileResponse();
        $container->session = $this->getSession();
        $container->logger = $this->getLogger();
        $container->applicationInfo = $this->getApplicationInfo();
        $container->coreDelegator = $this->getCoreDelegator($container);
        $container->annotationDelegator = $this->getAnnotationDelegator($container);

        $app = new Application($container);
        $app->run();

        // 実際にはこのファイル名が画面出力される
        $this->expectOutputString($filename);
    }

    /**
     * 異常系
     * ルーティング定義に存在しないControllerにアクセスした場合、ステータスコードが404になること
     * @test
     * @dataProvider notRunControllerProvider
     */
    public function ngNotRunController($path, $ca, $notfoundPath, $response)
    {
        $container = new Container();
        $container->request = $this->getRequest($notfoundPath);
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

    /**
     * 異常系
     * Controllerから存在しないServiceにアクセスし、Modelも存在しない場合、
     * ModelオブジェクトはWebStream\Delegate\CoreExceptionDelegatorで、ステータスコードが500になること
     * @test
     * @dataProvider notRunServiceAndModelProvider
     */
    public function ngNotRunServiceAndModel($path, $ca, $response)
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

        ob_start();
        $app = new Application($container);
        $app->run();
        $actual = ob_get_clean();

        $this->assertEquals($actual, $response);
    }
}
