<?php
namespace WebStream\Test\TestData\Sample\App\Controller;

use WebStream\Core\CoreController;
use WebStream\Annotation\Template;
use WebStream\Module\Utility\FileUtils;
use WebStream\DI\ServiceLocator;

class TestLoggerAdapterController extends CoreController
{
    use FileUtils;

    public function controllerTest()
    {
        $this->logger->enableDirectWrite();
        $this->logger->debug("controller logger");
        echo $this->logTail();
    }

    public function serviceTest()
    {
        $this->logger->enableDirectWrite();
        $this->TestLoggerAdapter->serviceTest();
        echo $this->logTail();
    }

    public function modelTest()
    {
        $this->logger->enableDirectWrite();
        $this->TestLoggerAdapter->modelTest();
        echo $this->logTail();
    }

    /**
     * @Template("logger_adapter.tmpl")
     */
    public function helperTest()
    {
    }

    private function logTail()
    {
        $log = $this->parseConfig("config/log_config/log.test.debug.ok.ini");
        $root = ServiceLocator::getInstance()->getContainer()->applicationInfo->applicationRoot;
        $logPath = $root . "/" . $log["path"];
        $file = file($logPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        return array_pop($file);
    }
}
