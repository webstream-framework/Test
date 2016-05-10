<?php
namespace WebStream\Test\IntegrationTest\Controller;

use WebStream\Core\CoreController;

class TestNoServiceClassExistModelController extends CoreController
{
    public function test1()
    {
        $this->TestNoServiceClassExistModel->exist();
    }
}
