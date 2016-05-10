<?php
namespace WebStream\Test\IntegrationTest\Controller;

use WebStream\Core\CoreController;

class TestNoServiceClassController extends CoreController
{
    public function test1()
    {
        $this->TestNoServiceClass->notFound();
    }
}
