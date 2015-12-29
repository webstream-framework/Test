<?php
namespace WebStream\Test\TestData\Sample\App\Helper;

use WebStream\Core\CoreHelper;
use WebStream\Module\Utility\FileUtils;
use WebStream\DI\ServiceLocator;

class TestLoggerAdapterHelper extends CoreHelper
{
    use FileUtils;

    public function loggerAdapter()
    {
        $this->logger->debug("helper logger");
        echo $this->logTail();
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
