<?php
namespace WebStream\Test\IntegrationTest\Controller;

use WebStream\Core\CoreController;

class TestSqliteController extends CoreController
{
    public function directSelectQuery()
    {
        $this->TestSqlite->setUp("direct_select");
        $this->print($this->TestSqlite->directSelectQuery());
        $this->TestSqlite->cleanUp();
    }

    public function annotationSelectQuery()
    {
        $this->TestSqlite->setUp("annotation_select");
        $this->print($this->TestSqlite->annotationSelectQuery());
        $this->TestSqlite->cleanUp();
    }

    public function directInsertQuery()
    {
        $this->TestSqlite->directInsertQuery("direct_insert");
        $this->print($this->TestSqlite->pop());
        $this->TestSqlite->cleanUp();
    }

    public function annotationInsertQuery()
    {
        $this->TestSqlite->annotationInsertQuery("annotation_insert");
        $this->print($this->TestSqlite->pop());
        $this->TestSqlite->cleanUp();
    }

    public function directUpdateQuery()
    {
        $this->TestSqlite->setUp("dummy");
        $this->TestSqlite->directUpdateQuery("direct_update");
        $this->print($this->TestSqlite->pop());
        $this->TestSqlite->cleanUp();
    }

    public function annotationUpdateQuery()
    {
        $this->TestSqlite->setUp("dummy");
        $this->TestSqlite->annotationUpdateQuery("annotation_update");
        $this->print($this->TestSqlite->pop());
        $this->TestSqlite->cleanUp();
    }

    public function directDeleteQuery()
    {
        $this->TestSqlite->setUp("dummy");
        $this->TestSqlite->directDeleteQuery();
        echo count($this->TestSqlite->pop());
    }

    public function annotationDeleteQuery()
    {
        $this->TestSqlite->setUp("dummy");
        $this->TestSqlite->annotationDeleteQuery();
        echo count($this->TestSqlite->pop());
    }

    public function print($result)
    {
        echo $result->toArray()[0]["name"];
    }
}
