<?php
namespace WebStream\Test\IntegrationTest\Controller;

use WebStream\Core\CoreController;

class TestMysqlYmlController extends CoreController
{
    public function directSelectQuery()
    {
        $this->TestMysqlYml->setUp("direct_select");
        echo $this->TestMysqlYml->directSelectQuery()->toArray()[0]["name"];
        $this->TestMysqlYml->cleanUp();
    }
}
