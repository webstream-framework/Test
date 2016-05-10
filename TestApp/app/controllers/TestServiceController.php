<?php
namespace WebStream\Test\IntegrationTest\Controller;

use WebStream\Core\CoreController;

class TestServiceController extends CoreController
{
    public function test1()
    {
        $this->TestService->test1();
    }

    public function test2()
    {
        $this->TestService->notfound();
    }
}
