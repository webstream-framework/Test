<?php
namespace WebStream\Test\IntegrationTest\Controller;

use WebStream\Core\CoreController;

class TestMysqlController extends CoreController
{
    public function directSelectQuery()
    {
        $this->TestMysql->setUp("direct_select");
        $this->print($this->TestMysql->directSelectQuery());
        $this->TestMysql->cleanUp();
    }

    public function annotationSelectQuery()
    {
        $this->TestMysql->setUp("annotation_select");
        $this->print($this->TestMysql->annotationSelectQuery());
        $this->TestMysql->cleanUp();
    }

    public function directInsertQuery()
    {
        $this->TestMysql->directInsertQuery("direct_insert");
        $this->print($this->TestMysql->pop());
        $this->TestMysql->cleanUp();
    }

    public function annotationInsertQuery()
    {
        $this->TestMysql->annotationInsertQuery("annotation_insert");
        $this->print($this->TestMysql->pop());
        $this->TestMysql->cleanUp();
    }


    public function print($result)
    {
        echo $result->toArray()[0]["name"];
    }
}
