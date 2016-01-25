<?php
namespace WebStream\Test\UnitTest;

use WebStream\Core\Application;
use WebStream\Core\CoreController;
use WebStream\Annotation\Validate;
use WebStream\Delegate\Router;
use WebStream\Delegate\CoreDelegator;
use WebStream\Delegate\AnnotationDelegator;
use WebStream\Module\Utility\ApplicationUtils;
use WebStream\Module\Container;
use WebStream\Http\Request;
use WebStream\Http\Response;
use WebStream\Test\UnitTest\DataProvider\ValidateProvider;

require_once dirname(__FILE__) . '/TestBase.php';
require_once dirname(__FILE__) . '/DataProvider/ValidateProvider.php';

/**
 * ValidateTest
 * @author Ryuichi TANAKA.
 * @since 2016/01/19
 * @version 0.7
 */
class ValidateTest extends \PHPUnit_Framework_TestCase
{
    use ValidateProvider, ApplicationUtils;

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
        $container = $request->getContainer();
        $container->get = [];
        $container->post = [];
        $container->put = [];
        $container->delete = [];

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
            $info->validateRuleDir = "core/WebStream/Validate/Rule/";

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
                    /**
                     * @Validate(key="test", rule="required", method="get")
                     */
                    public function getRequired()
                    {
                        echo $this->request->get["test"];
                    }

                    /**
                     * @Validate(key="test", rule="required", method="post")
                     */
                    public function postRequired()
                    {
                        echo $this->request->post["test"];
                    }

                    /**
                     * @Validate(key="test", rule="required", method="put")
                     */
                    public function putRequired()
                    {
                        echo $this->request->put["test"];
                    }

                    /**
                     * @Validate(key="test", rule="required", method="delete")
                     */
                    public function deleteRequired()
                    {
                        echo $this->request->delete["test"];
                    }

                    /**
                     * @Validate(key="test", rule="required")
                     */
                    public function allRequired()
                    {
                        $key = "test";
                        if (array_key_exists($key, $this->request->get)) {
                            echo $this->request->get[$key];
                        } elseif (array_key_exists($key, $this->request->post)) {
                            echo $this->request->post[$key];
                        } elseif (array_key_exists($key, $this->request->put)) {
                            echo $this->request->put[$key];
                        } elseif (array_key_exists($key, $this->request->delete)) {
                            echo $this->request->delete[$key];
                        }
                    }

                    /**
                     * @Validate(key="test", rule="equal[yryr]", method="get")
                     */
                    public function getEqual()
                    {
                        echo $this->request->get["test"];
                    }

                    /**
                     * @Validate(key="test", rule="equal[yryr]", method="post")
                     */
                    public function postEqual()
                    {
                        echo $this->request->post["test"];
                    }

                    /**
                     * @Validate(key="test", rule="equal[yryr]", method="put")
                     */
                    public function putEqual()
                    {
                        echo $this->request->put["test"];
                    }

                    /**
                     * @Validate(key="test", rule="equal[yryr]", method="delete")
                     */
                    public function deleteEqual()
                    {
                        echo $this->request->delete["test"];
                    }

                    /**
                     * @Validate(key="test", rule="equal[yryr]")
                     */
                    public function allEqual()
                    {
                        $key = "test";
                        if (array_key_exists($key, $this->request->get)) {
                            echo $this->request->get[$key];
                        } elseif (array_key_exists($key, $this->request->post)) {
                            echo $this->request->post[$key];
                        } elseif (array_key_exists($key, $this->request->put)) {
                            echo $this->request->put[$key];
                        } elseif (array_key_exists($key, $this->request->delete)) {
                            echo $this->request->delete[$key];
                        }
                    }

                    /**
                     * @Validate(key="test", rule="length[4]", method="get")
                     */
                    public function getLength()
                    {
                        echo $this->request->get["test"];
                    }

                    /**
                     * @Validate(key="test", rule="length[4]", method="post")
                     */
                    public function postLength()
                    {
                        echo $this->request->post["test"];
                    }

                    /**
                     * @Validate(key="test", rule="length[4]", method="put")
                     */
                    public function putLength()
                    {
                        echo $this->request->put["test"];
                    }

                    /**
                     * @Validate(key="test", rule="length[4]", method="delete")
                     */
                    public function deleteLength()
                    {
                        echo $this->request->delete["test"];
                    }

                    /**
                     * @Validate(key="test", rule="length[4]")
                     */
                    public function allLength()
                    {
                        $key = "test";
                        if (array_key_exists($key, $this->request->get)) {
                            echo $this->request->get[$key];
                        } elseif (array_key_exists($key, $this->request->post)) {
                            echo $this->request->post[$key];
                        } elseif (array_key_exists($key, $this->request->put)) {
                            echo $this->request->put[$key];
                        } elseif (array_key_exists($key, $this->request->delete)) {
                            echo $this->request->delete[$key];
                        }
                    }

                    /**
                     * @Validate(key="test", rule="max[3]", method="get")
                     */
                    public function getMax()
                    {
                        echo $this->request->get["test"];
                    }

                    /**
                     * @Validate(key="test", rule="max[3]", method="post")
                     */
                    public function postMax()
                    {
                        echo $this->request->post["test"];
                    }

                    /**
                     * @Validate(key="test", rule="max[3]", method="put")
                     */
                    public function putMax()
                    {
                        echo $this->request->put["test"];
                    }

                    /**
                     * @Validate(key="test", rule="max[3]", method="delete")
                     */
                    public function deleteMax()
                    {
                        echo $this->request->delete["test"];
                    }

                    /**
                     * @Validate(key="test", rule="max[3]")
                     */
                    public function allMax()
                    {
                        $key = "test";
                        if (array_key_exists($key, $this->request->get)) {
                            echo $this->request->get[$key];
                        } elseif (array_key_exists($key, $this->request->post)) {
                            echo $this->request->post[$key];
                        } elseif (array_key_exists($key, $this->request->put)) {
                            echo $this->request->put[$key];
                        } elseif (array_key_exists($key, $this->request->delete)) {
                            echo $this->request->delete[$key];
                        }
                    }

                    /**
                     * @Validate(key="test", rule="min[1]", method="get")
                     */
                    public function getMin()
                    {
                        echo $this->request->get["test"];
                    }

                    /**
                     * @Validate(key="test", rule="min[1]", method="post")
                     */
                    public function postMin()
                    {
                        echo $this->request->post["test"];
                    }

                    /**
                     * @Validate(key="test", rule="min[1]", method="put")
                     */
                    public function putMin()
                    {
                        echo $this->request->put["test"];
                    }

                    /**
                     * @Validate(key="test", rule="min[1]", method="delete")
                     */
                    public function deleteMin()
                    {
                        echo $this->request->delete["test"];
                    }

                    /**
                     * @Validate(key="test", rule="min[1]")
                     */
                    public function allMin()
                    {
                        $key = "test";
                        if (array_key_exists($key, $this->request->get)) {
                            echo $this->request->get[$key];
                        } elseif (array_key_exists($key, $this->request->post)) {
                            echo $this->request->post[$key];
                        } elseif (array_key_exists($key, $this->request->put)) {
                            echo $this->request->put[$key];
                        } elseif (array_key_exists($key, $this->request->delete)) {
                            echo $this->request->delete[$key];
                        }
                    }

                    /**
                     * @Validate(key="test", rule="max_length[6]", method="get")
                     */
                    public function getMaxLength()
                    {
                        echo $this->request->get["test"];
                    }

                    /**
                     * @Validate(key="test", rule="max_length[6]", method="post")
                     */
                    public function postMaxLength()
                    {
                        echo $this->request->post["test"];
                    }

                    /**
                     * @Validate(key="test", rule="max_length[6]", method="put")
                     */
                    public function putMaxLength()
                    {
                        echo $this->request->put["test"];
                    }

                    /**
                     * @Validate(key="test", rule="max_length[6]", method="delete")
                     */
                    public function deleteMaxLength()
                    {
                        echo $this->request->delete["test"];
                    }

                    /**
                     * @Validate(key="test", rule="max_length[6]")
                     */
                    public function allMaxLength()
                    {
                        $key = "test";
                        if (array_key_exists($key, $this->request->get)) {
                            echo $this->request->get[$key];
                        } elseif (array_key_exists($key, $this->request->post)) {
                            echo $this->request->post[$key];
                        } elseif (array_key_exists($key, $this->request->put)) {
                            echo $this->request->put[$key];
                        } elseif (array_key_exists($key, $this->request->delete)) {
                            echo $this->request->delete[$key];
                        }
                    }

                    /**
                     * @Validate(key="test", rule="min_length[6]", method="get")
                     */
                    public function getMinLength()
                    {
                        echo $this->request->get["test"];
                    }

                    /**
                     * @Validate(key="test", rule="min_length[6]", method="post")
                     */
                    public function postMinLength()
                    {
                        echo $this->request->post["test"];
                    }

                    /**
                     * @Validate(key="test", rule="min_length[6]", method="put")
                     */
                    public function putMinLength()
                    {
                        echo $this->request->put["test"];
                    }

                    /**
                     * @Validate(key="test", rule="min_length[6]", method="delete")
                     */
                    public function deleteMinLength()
                    {
                        echo $this->request->delete["test"];
                    }

                    /**
                     * @Validate(key="test", rule="min_length[6]")
                     */
                    public function allMinLength()
                    {
                        $key = "test";
                        if (array_key_exists($key, $this->request->get)) {
                            echo $this->request->get[$key];
                        } elseif (array_key_exists($key, $this->request->post)) {
                            echo $this->request->post[$key];
                        } elseif (array_key_exists($key, $this->request->put)) {
                            echo $this->request->put[$key];
                        } elseif (array_key_exists($key, $this->request->delete)) {
                            echo $this->request->delete[$key];
                        }
                    }

                    /**
                     * @Validate(key="test", rule="number", method="get")
                     */
                    public function getNumber()
                    {
                        echo $this->request->get["test"];
                    }

                    /**
                     * @Validate(key="test", rule="number", method="post")
                     */
                    public function postNumber()
                    {
                        echo $this->request->post["test"];
                    }

                    /**
                     * @Validate(key="test", rule="number", method="put")
                     */
                    public function putNumber()
                    {
                        echo $this->request->put["test"];
                    }

                    /**
                     * @Validate(key="test", rule="number", method="delete")
                     */
                    public function deleteNumber()
                    {
                        echo $this->request->delete["test"];
                    }

                    /**
                     * @Validate(key="test", rule="number")
                     */
                    public function allNumber()
                    {
                        $key = "test";
                        if (array_key_exists($key, $this->request->get)) {
                            echo $this->request->get[$key];
                        } elseif (array_key_exists($key, $this->request->post)) {
                            echo $this->request->post[$key];
                        } elseif (array_key_exists($key, $this->request->put)) {
                            echo $this->request->put[$key];
                        } elseif (array_key_exists($key, $this->request->delete)) {
                            echo $this->request->delete[$key];
                        }
                    }

                    /**
                     * @Validate(key="test", rule="range[1..10]", method="get")
                     */
                    public function getRange()
                    {
                        echo $this->request->get["test"];
                    }

                    /**
                     * @Validate(key="test", rule="range[1..10]", method="post")
                     */
                    public function postRange()
                    {
                        echo $this->request->post["test"];
                    }

                    /**
                     * @Validate(key="test", rule="range[1..10]", method="put")
                     */
                    public function putRange()
                    {
                        echo $this->request->put["test"];
                    }

                    /**
                     * @Validate(key="test", rule="range[1..10]", method="delete")
                     */
                    public function deleteRange()
                    {
                        echo $this->request->delete["test"];
                    }

                    /**
                     * @Validate(key="test", rule="range[1..10]")
                     */
                    public function allRange()
                    {
                        $key = "test";
                        if (array_key_exists($key, $this->request->get)) {
                            echo $this->request->get[$key];
                        } elseif (array_key_exists($key, $this->request->post)) {
                            echo $this->request->post[$key];
                        } elseif (array_key_exists($key, $this->request->put)) {
                            echo $this->request->put[$key];
                        } elseif (array_key_exists($key, $this->request->delete)) {
                            echo $this->request->delete[$key];
                        }
                    }

                    /**
                     * @Validate(key="test", rule="regexp[/^\d+$/]", method="get")
                     */
                    public function getRegexp()
                    {
                        echo $this->request->get["test"];
                    }

                    /**
                     * @Validate(key="test", rule="regexp[/^\d+$/]", method="post")
                     */
                    public function postRegexp()
                    {
                        echo $this->request->post["test"];
                    }

                    /**
                     * @Validate(key="test", rule="regexp[/^\d+$/]", method="put")
                     */
                    public function putRegexp()
                    {
                        echo $this->request->put["test"];
                    }

                    /**
                     * @Validate(key="test", rule="regexp[/^\d+$/]", method="delete")
                     */
                    public function deleteRegexp()
                    {
                        echo $this->request->delete["test"];
                    }

                    /**
                     * @Validate(key="test", rule="regexp[/^\d+$/]")
                     */
                    public function allRegexp()
                    {
                        $key = "test";
                        if (array_key_exists($key, $this->request->get)) {
                            echo $this->request->get[$key];
                        } elseif (array_key_exists($key, $this->request->post)) {
                            echo $this->request->post[$key];
                        } elseif (array_key_exists($key, $this->request->put)) {
                            echo $this->request->put[$key];
                        } elseif (array_key_exists($key, $this->request->delete)) {
                            echo $this->request->delete[$key];
                        }
                    }

                    /**
                     * @Validate(key="test", rule="unknown")
                     */
                    public function invalidRuleUnknown()
                    {
                    }

                    /**
                     * @Validate(key="test", rule="required[]")
                     */
                    public function invalidRuleRequired()
                    {
                    }

                    /**
                     * @Validate(key="test", rule="equal[]")
                     */
                    public function invalidRuleEqual()
                    {
                    }

                    /**
                     * @Validate(key="test", rule="length[-1]")
                     */
                    public function invalidRuleLength1()
                    {
                    }

                    /**
                     * @Validate(key="test", rule="length[hoge]")
                     */
                    public function invalidRuleLength2()
                    {
                    }

                    /**
                     * @Validate(key="test", rule="length")
                     */
                    public function invalidRuleLength3()
                    {
                    }

                    /**
                     * @Validate(key="test", rule="max[hoge]")
                     */
                    public function invalidRuleMax()
                    {
                    }

                    /**
                     * @Validate(key="test", rule="min[hoge]")
                     */
                    public function invalidRuleMin()
                    {
                    }

                    /**
                     * @Validate(key="test", rule="max_length[hoge]")
                     */
                    public function invalidRuleMaxLength()
                    {
                    }

                    /**
                     * @Validate(key="test", rule="min_length[hoge]")
                     */
                    public function invalidRuleMinLength()
                    {
                    }

                    /**
                     * @Validate(key="test", rule="number[]")
                     */
                    public function invalidRuleNumber()
                    {
                    }

                    /**
                     * @Validate(key="test", rule="range[hoge..hoge]")
                     */
                    public function invalidRuleRange1()
                    {
                    }

                    /**
                     * @Validate(key="test", rule="range[1...10]")
                     */
                    public function invalidRuleRange2()
                    {
                    }

                    /**
                     * @Validate(key="test", rule="regexp[hoge]")
                     */
                    public function invalidRuleRegexp()
                    {
                    }

                    /**
                     * @Validate(rule="required")
                     */
                    public function invalidValidateAnnotation1()
                    {
                        // key属性指定なし
                    }

                    /**
                     * @Validate(key="test")
                     */
                    public function invalidValidateAnnotation2()
                    {
                        // rule属性指定なし
                    }

                    /**
                     * @Validate(key="test", rule="invalid")
                     */
                    public function duplicateValidateRule()
                    {
                        // 同一クラス名(クラスパスが異なってもNG)
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
     * バリデーションルールが適用され、正常に処理されること
     * @test
     * @dataProvider validateProvider
     */
    public function okValidate($path, $ca, $requestMethod, $reqKey, $reqValue)
    {
        $container = new Container();
        $container->request = $this->getRequest($path);
        $container->request->requestMethod = strtoupper($requestMethod);
        $container->request->{$requestMethod} = [$reqKey => $reqValue];
        $container->router = $this->getRouter([$path => $ca], $container->request);
        $container->response = $this->getResponse();
        $container->session = $this->getSession();
        $container->logger = $this->getLogger();
        $container->applicationInfo = $this->getApplicationInfo();
        $container->coreDelegator = $this->getCoreDelegator($container);
        $container->annotationDelegator = $this->getAnnotationDelegator($container);

        $app = new Application($container);
        $app->run();

        $this->expectOutputString($reqValue);
    }

    /**
     * 異常系
     * バリデーションルールが適用され、処理が実行されないこと
     * @test
     * @dataProvider validateErrorProvider
     */
    public function ngValidateError($path, $ca, $requestMethod, $reqKey, $reqValue)
    {
        $container = new Container();
        $container->request = $this->getRequest($path);
        $container->request->requestMethod = strtoupper($requestMethod);
        $container->request->{$requestMethod} = [$reqKey => $reqValue];
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

        $this->assertEquals($actual, 422);
    }

    /**
     * 異常系
     * バリデーション定義が間違っている場合、例外が発生すること
     * @test
     * @dataProvider validateDefinitionErrorProvider
     */
    public function ngValidateDefinitionError($path, $ca)
    {
        $container = new Container();
        $container->request = $this->getRequest($path);
        $container->request->requestMethod = "GET";
        $container->request->get = ["test" => "dummy"];
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

        $this->assertEquals($actual, 422);
    }
}
