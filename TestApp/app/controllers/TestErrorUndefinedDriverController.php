<?php
namespace WebStream\Test\IntegrationTest\Controller;

use WebStream\Core\CoreController;
use WebStream\Annotation\ExceptionHandler;

class TestErrorUndefinedDriverController extends CoreController
{
    public function undefinedDriver()
    {
        $this->TestErrorUndefinedDriver->undefinedDriver();
    }

    /**
     * @ExceptionHandler("WebStream\Exception\Extend\DatabaseException")
     */
    public function handle($params)
    {
        echo $params["exception"];
    }
}
