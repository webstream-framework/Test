<?php
namespace WebStream\Test\IntegrationTest\Controller;

use WebStream\Core\CoreController;

class TestMultipleDatabaseController extends CoreController
{
    public function multipleDatabaseAccess()
    {
        $result = $this->TestMultipleDatabase->multipleDatabaseAccess();
        var_dump("aaa");
    }
}
