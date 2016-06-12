<?php
namespace WebStream\Test\IntegrationTest\Controller;

use WebStream\Core\CoreController;
use WebStream\Annotation\ExceptionHandler;

class TestErrorUndefinedQueryController extends CoreController
{
    public function undefinedQuery()
    {
        $this->TestErrorUndefinedQuery->undefinedQuery();
    }

    public function undefinedQueryMapping()
    {
        $this->TestErrorUndefinedQuery->undefinedQueryMapping();
    }

    /**
     * @ExceptionHandler("WebStream\Exception\Extend\DatabaseException")
     */
    public function handle($params)
    {
        echo $params["exception"];
    }
}
