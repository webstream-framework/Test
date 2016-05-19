<?php
namespace WebStream\Test\IntegrationTest\Controller;

use WebStream\Core\CoreController;

class TestMultipleDatabaseController extends CoreController
{
    public function multipleDatabaseAccess()
    {
        echo "test";
        // $result = $this->TestMultipleDatabase->multipleDatabaseAccess();

        // var_dump($result);
    }
}
