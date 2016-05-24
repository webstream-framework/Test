<?php
namespace WebStream\Test\IntegrationTest\Controller;

use WebStream\Core\CoreController;

class TestMultipleDatabaseController extends CoreController
{
    public function multipleDatabaseAccess()
    {
        $result = $this->TestMultipleDatabase->multipleDatabaseAccess();
        foreach ($result as $item) {
            echo $item->toArray()[0]["name"];
        }
    }
}
