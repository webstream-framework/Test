<?php
namespace WebStream\Test\TestData\Sample\App\Controller;

use WebStream\Core\CoreController;
use WebStream\Annotation\Inject;
use WebStream\Annotation\ExceptionHandler;

class TestDatabaseError3Controller extends CoreController
{
    public function model1()
    {
        $this->TestDatabaseError3->model1();
    }

    public function model2()
    {
        $this->TestDatabaseError3->model2();
    }

    /**
     * @Inject
     * @ExceptionHandler("WebStream\Exception\Extend\DatabaseException")
     */
    public function handle($params)
    {
        echo $params["class"] . "#" . $params["method"];
    }
}
