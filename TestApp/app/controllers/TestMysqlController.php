<?php
namespace WebStream\Test\IntegrationTest\Controller;

use WebStream\Core\CoreController;

class TestMysqlController extends CoreController
{
    public function test1()
    {
        $this->TestMysql->setUp("mikashi-");
        $this->TestMysql->selectDirectSqlExecute();
    }
}
