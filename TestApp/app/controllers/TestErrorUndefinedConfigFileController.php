<?php
namespace WebStream\Test\IntegrationTest\Controller;

use WebStream\Core\CoreController;
use WebStream\Annotation\ExceptionHandler;

class TestErrorUndefinedConfigFileController extends CoreController
{
    public function undefinedConfigFile()
    {
        $this->TestErrorUndefinedConfigFile->undefinedConfigFile();
    }

    /**
     * @ExceptionHandler("WebStream\Exception\Extend\DatabaseException")
     */
    public function handle($params)
    {
        echo $params["exception"];
    }
}
