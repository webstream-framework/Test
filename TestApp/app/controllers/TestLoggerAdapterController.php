<?php
namespace WebStream\Test\TestData\Sample\App\Controller;

use WebStream\Core\CoreController;
use WebStream\Annotation\Inject;
use WebStream\Annotation\Template;

class TestLoggerAdapterController extends CoreController
{
    public function controllerTest()
    {
        $this->logger->debug("controller logger");
        echo $this->logTail();
    }

    public function serviceTest()
    {
        $this->TestLoggerAdapter->serviceTest();
        echo $this->logTail();
    }

    public function modelTest()
    {
        $this->TestLoggerAdapter->modelTest();
        echo $this->logTail();
    }

    /**
     * @Inject
     * @Template("logger_adapter.tmpl")
     */
    public function helperTest()
    {
    }

    private function logTail()
    {
        $log = $this->parseConfig("config/log_config/log.test.debug.ok.ini");
        $logPath = $this->getRoot() . "/" . $log["path"];
        $file = file($logPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        return array_pop($file);
    }
}
