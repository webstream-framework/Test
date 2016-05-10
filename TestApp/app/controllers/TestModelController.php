<?php
namespace WebStream\Test\IntegrationTest\Controller;

use WebStream\Core\CoreController;

class TestModelController extends CoreController
{
    public function test1()
    {
        $this->TestModel->test1();
    }
}
