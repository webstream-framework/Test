<?php
namespace WebStream\Test;

use WebStream\Module\Utility;
use WebStream\Module\Logger;

require_once dirname(__FILE__) . '/TestConstant.php';
require_once dirname(__FILE__) . '/../TestApp/vendor/autoload.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Module/Functions.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Module/ClassLoader.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Module/Utility.php';
require_once dirname(__FILE__) . '/../TestApp/core/WebStream/Module/Logger.php';

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
    }

    protected function autoLoad()
    {
        $classLoader = new \WebStream\Module\ClassLoader();
        // $classLoader->test();
        spl_autoload_register([$classLoader, "load"]);
        register_shutdown_function('shutdownHandler');
    }

    protected function preloadClass()
    {
        $classLoader = new \WebStream\Module\ClassLoader();
        // $classLoader->test();
        $classLoader->load([
            "WebStream\Annotation\Autowired",
            "WebStream\Annotation\Inject",
            "WebStream\Annotation\Filter",
            "WebStream\Annotation\Template",
            "WebStream\Annotation\Header",
            "WebStream\Annotation\Query",
            "WebStream\Annotation\ExceptionHandler",
            "WebStream\Annotation\Database",
            "WebStream\Annotation\Validate",
            "Doctrine\Common\Annotations\AnnotationException"
        ]);
    }
}
