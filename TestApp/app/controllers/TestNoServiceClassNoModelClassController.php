<?php
namespace WebStream\Test\IntegrationTest\Controller;

use WebStream\Core\CoreController;

class TestNoServiceClassNoModelClassController extends CoreController
{
    public function test1()
    {
        $this->TestNoServiceClassNoModelClass->notFound();
    }
}
