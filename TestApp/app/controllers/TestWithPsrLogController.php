<?php
namespace WebStream\Test\TestData\Sample\App\Controller;

use WebStream\Core\CoreController;
use WebStream\Module\Logger;
use WebStream\Module\LoggerAdapter;

class TestWithPsrLogController extends CoreController
{
    public function loggerAdapterTest()
    {
        $logger = new LoggerAdapter(Logger::getInstance());
        $logger->fatal("loggerAdapter");
        $logger->fatal("{ name } is { nickname }", ["name" => "umi", "nickname" => "umichang"]);

        Logger::owata("hoge");
    }
}
