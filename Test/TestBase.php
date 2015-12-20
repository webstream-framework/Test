<?php
namespace WebStream\Test;

use WebStream\Module\Utility;
use WebStream\Log\Logger;

require_once dirname(__FILE__) . '/TestConstant.php';
require_once dirname(__FILE__) . '/../TestApp/vendor/autoload.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Module/Utility.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Log/Logger.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Log/LoggerFormatter.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Log/LoggerAdapter.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Module/Functions.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Module/ClassLoader.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Module/HttpClient.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Exception/SystemException.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Exception/Extend/LoggerException.php';

/**
 * ユニットテスト基底クラス
 * @author Ryuichi TANAKA.
 * @since 2013/09/02
 * @version 0.4
 */
class TestBase extends \PHPUnit_Framework_TestCase
{
    use TestConstant, Utility;

    public function setUp()
    {
        $this->autoLoad();
        Logger::init($this->getLogConfigPath() . "/log.test.debug.ok.ini");
        $this->preloadClass();
    }

    public function tearDown()
    {
        Logger::finalize();
    }

    protected function autoLoad()
    {
        $classLoader = new \WebStream\Module\ClassLoader();
        spl_autoload_register([$classLoader, "load"]);
        register_shutdown_function('shutdownHandler');
    }

    protected function preloadClass()
    {
        $classLoader = new \WebStream\Module\ClassLoader();
        $classLoader->load([
            "WebStream\Annotation\Autowired",
            "WebStream\Annotation\Filter",
            "WebStream\Annotation\Template",
            "WebStream\Annotation\Header",
            "WebStream\Annotation\Query",
            "WebStream\Annotation\ExceptionHandler",
            "WebStream\Annotation\Database",
            "WebStream\Annotation\Validate",
            "WebStream\Annotation\Alias",
            "Doctrine\Common\Annotations\AnnotationException"
        ]);
    }
}
