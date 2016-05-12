<?php
namespace WebStream\Test\IntegrationTest\Controller;

use WebStream\Core\CoreController;

class TestParentController extends CoreController
{
    public function test1()
    {
        echo "parent";
    }
}
