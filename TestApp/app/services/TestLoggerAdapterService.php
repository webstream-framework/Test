<?php
namespace WebStream\Test\TestData\Sample\App\Service;

use WebStream\Core\CoreService;

class TestLoggerAdapterService extends CoreService
{
    public function serviceTest()
    {
        $this->logger->debug("service logger");
    }
}
