<?php
namespace WebStream\Test\UnitTest;

use WebStream\Core\Application;
use WebStream\Core\CoreController;
use WebStream\Core\CoreModel;
use WebStream\Annotation\container\AnnotationListContainer;
use WebStream\Database\Driver\DatabaseDriver;
use WebStream\Database\DatabaseManager;
use WebStream\Database\ConnectionManager;
use WebStream\Database\Query;
use WebStream\Delegate\Router;
use WebStream\Delegate\CoreDelegator;
use WebStream\Delegate\AnnotationDelegator;
use WebStream\Module\Utility\ApplicationUtils;
use WebStream\Module\Container;
use WebStream\Http\Request;
use WebStream\Http\Response;
use WebStream\Test\UnitTest\DataProvider\ModelProvider;

require_once dirname(__FILE__) . '/TestBase.php';
require_once dirname(__FILE__) . '/DataProvider/ModelProvider.php';

/**
 * ModelTest
 * @author Ryuichi TANAKA.
 * @since 2016/01/07
 * @version 0.7
 */
class ModelTest extends \PHPUnit_Framework_TestCase
{
    use ModelProvider, ApplicationUtils;

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
        return new class()
        {
            public function __call($name, $args) {}
            public function move($statusCode) {}
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
                return new class($this->container) extends CoreController
                {
                    public function testFoundModel()
                    {
                        $this->UnitTest->foundModel();
                    }

                    public function executeSelect()
                    {
                        $this->UnitTest->executeSelect();
                    }

                    public function executeInsert()
                    {
                        $this->UnitTest->executeInsert();
                    }

                    public function executeUpdate()
                    {
                        $this->UnitTest->executeUpdate();
                    }

                    public function executeDelete()
                    {
                        $this->UnitTest->executeDelete();
                    }

                    public function executeXmlQuery()
                    {
                        $this->UnitTest->executeXmlQuery();
                    }

                    public function executeXmlQueryToEntity()
                    {
                        $this->UnitTest->executeXmlQueryToEntity();
                    }
                };
            }

            public function getModel()
            {
                $model = new class($this->container) extends CoreModel
                {
                    public function foundModel()
                    {
                        echo "m";
                    }

                    public function executeSelect()
                    {
                        $result = $this->select("sql", []);
                        echo get_class($result);
                    }

                    public function executeInsert()
                    {
                        echo $this->insert("sql", []);
                    }

                    public function executeUpdate()
                    {
                        echo $this->update("sql", []);
                    }

                    public function executeDelete()
                    {
                        echo $this->delete("sql", []);
                    }

                    public function executeXmlQuery()
                    {
                        $result = $this->xmlQuery([]);
                        if (is_int($result)) {
                            echo $result;
                        }
                        else {
                            echo get_class($result);
                        }
                    }

                    public function executeXmlQueryToEntity()
                    {
                        $result = $this->xmlQueryToEntity();
                        echo get_class($result);
                    }
                };

                $connContainer = new Container(false);
                $connContainer->connectionContainerList = [];
                $conn = new class($connContainer) extends ConnectionManager
                {
                    public function getConnection($filepath)
                    {
                        require_once dirname(__FILE__) . '/TestDatabaseMock.php';
                        $mockContainer = new Container(false);
                        $mockDriver = new class($mockContainer) extends DatabaseDriver
                        {
                            public function connect() {}

                            public function getStatement($sql)
                            {
                                $mock = new TestDatabaseMock();
                                return $mock->getStatementMock();
                            }

                            public function __call($name, $args) { return true; }
                        };
                        $mock = new TestDatabaseMock();
                        $mockDriver->inject('connection', $mock->getConnectionMock());
                        $mockDriver->inject('logger', new class() { function __call($name, $args) {} });

                        return $mockDriver;
                    }
                };

                $dbContainer = new Container(false);
                $dbContainer->logger = new class() { function __call($name, $args) {} };
                $dbContainer->connectionContainerList = [];

                $manager = new class($dbContainer) extends DatabaseManager
                {
                    public function isConnected()
                    {
                        return false;
                    }

                    public function beginTransaction() {}
                };
                $manager->inject('connectionManager', $conn);

                $queryId = "WebStream\Test\UnitTest\ModelTest" . "#" . $this->container->cmMethod;
                $queryAnnotations = new Container(false);
                $queryAnnotations->{$queryId} = new AnnotationListContainer();
                $crudMethod = $this->container->crudMethod;
                $toEntityFlg = $this->container->toEntityFlg;
                $queryAnnotations->{$queryId}->pushAsLazy(function () use ($crudMethod, $toEntityFlg) {
                    $mockXmlObject = new class($crudMethod, $toEntityFlg)
                    {
                        private $crudMethod;
                        private $toEntityFlg;
                        public function __construct($crudMethod, $toEntityFlg)
                        {
                            $this->crudMethod = $crudMethod;
                            $this->toEntityFlg = $toEntityFlg;
                        }
                        public function __call($name, $args) {}
                        public function xpath($path)
                        {
                            return new class($this->crudMethod, $this->toEntityFlg) implements \ArrayAccess
                            {
                                private $crudMethod;
                                private $toEntityFlg;
                                public function __construct($crudMethod, $toEntityFlg)
                                {
                                    $this->crudMethod = $crudMethod;
                                    $this->toEntityFlg = $toEntityFlg;
                                }

                                public function offsetExists($offset) {}
                                public function offsetGet($offset)
                                {
                                    return new class($this->crudMethod, $this->toEntityFlg)
                                    {
                                        private $crudMethod;
                                        private $toEntityFlg;
                                        public function __construct($crudMethod, $toEntityFlg)
                                        {
                                            $this->crudMethod = $crudMethod;
                                            $this->toEntityFlg = $toEntityFlg;
                                        }

                                        public function __call($name, $args) {}
                                        public function getName()
                                        {
                                            return $this->crudMethod;
                                        }
                                        public function attributes()
                                        {
                                            $ary = ["entity" => null];
                                            if ($this->toEntityFlg) {
                                                $ary["entity"] = new class()
                                                {
                                                    public function __toString()
                                                    {
                                                        // 存在するクラスパスならなんでもOK
                                                        return "WebStream\Test\UnitTest\ModelTest";
                                                    }
                                                };
                                            }

                                            return $ary;
                                        }
                                    };
                                }
                                public function offsetSet($offset, $value) {}
                                public function offsetUnSet($offset) {}
                                public function __call($name, $args) {}
                            };
                        }
                    };

                    return [$mockXmlObject];
                });

                $model->inject('manager', $manager);
                $model->inject('queryAnnotations', [$queryAnnotations]);
                $model->inject('classpath', get_class($this));

                return $model;
            }
        };
    }

    private function getAnnotationDelegator(Container $container)
    {
        return new AnnotationDelegator($container);
    }

    /**
     * 正常系
     * Modelにアクセスできること
     * @dataProvider runModelProvider
     */
    public function okRunModel($path, $ca, $response)
    {
        $container = new Container(false);
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
     * SELECT/INSERT/UPDATE/DELETEが実行できること
     * @test
     * @dataProvider executeCrudProvider
     */
    public function okExecuteCrud($path, $ca, $response)
    {
        $container = new Container(false);
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
     * SELECT/INSERT/UPDATE/DELETEがクエリファイル経由で実行できること
     * @test
     * @dataProvider executeCrudQueryFileProvider
     */
    public function okExecuteCrudQueryFile($path, $ca, $cmMethod, $response, $crudMethod, $toEntityFlg = false)
    {
        $container = new Container(false);
        $container->cmMethod = $cmMethod;
        $container->crudMethod = $crudMethod;
        $container->toEntityFlg = $toEntityFlg;
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
