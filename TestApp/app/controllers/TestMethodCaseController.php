<?php
namespace WebStream\Test\IntegrationTest\Controller;

use WebStream\Core\CoreController;

class TestMethodCaseController extends CoreController
{
    public function upperCase()
    {
        echo "u";
    }

    public function lowercase()
    {
        echo "l";
    }
}
