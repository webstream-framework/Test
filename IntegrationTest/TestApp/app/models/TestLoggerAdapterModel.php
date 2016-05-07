<?php
namespace WebStream\Test\TestData\Sample\App\Model;

use WebStream\Core\CoreModel;

class TestLoggerAdapterModel extends CoreModel
{
    public function modelTest()
    {
        $this->logger->debug("model logger");
    }
}
