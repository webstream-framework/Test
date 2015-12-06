<?php
namespace WebStream\Test\TestData\Sample\App\Helper;

use WebStream\Core\CoreHelper;

class TestLoggerAdapterHelper extends CoreHelper
{
    public function loggerAdapter()
    {
        $this->logger->debug("helper logger");
        echo $this->logTail();
    }

    private function logTail()
    {
        $log = $this->parseConfig("config/log_config/log.test.debug.ok.ini");
        $logPath = $this->getRoot() . "/" . $log["path"];
        $file = file($logPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        return array_pop($file);
    }
}
