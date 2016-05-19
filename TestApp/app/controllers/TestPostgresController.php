<?php
namespace WebStream\Test\IntegrationTest\Controller;

use WebStream\Core\CoreController;

class TestPostgresController extends CoreController
{
    public function directSelectQuery()
    {
        $this->TestPostgres->setUp("direct_select");
        $this->print($this->TestPostgres->directSelectQuery());
        $this->TestPostgres->cleanUp();
    }

    public function annotationSelectQuery()
    {
        $this->TestPostgres->setUp("annotation_select");
        $this->print($this->TestPostgres->annotationSelectQuery());
        $this->TestPostgres->cleanUp();
    }

    public function directInsertQuery()
    {
        $this->TestPostgres->directInsertQuery("direct_insert");
        $this->print($this->TestPostgres->pop());
        $this->TestPostgres->cleanUp();
    }

    public function annotationInsertQuery()
    {
        $this->TestPostgres->annotationInsertQuery("annotation_insert");
        $this->print($this->TestPostgres->pop());
        $this->TestPostgres->cleanUp();
    }

    public function directUpdateQuery()
    {
        $this->TestPostgres->setUp("dummy");
        $this->TestPostgres->directUpdateQuery("direct_update");
        $this->print($this->TestPostgres->pop());
        $this->TestPostgres->cleanUp();
    }

    public function annotationUpdateQuery()
    {
        $this->TestPostgres->setUp("dummy");
        $this->TestPostgres->annotationUpdateQuery("annotation_update");
        $this->print($this->TestPostgres->pop());
        $this->TestPostgres->cleanUp();
    }

    public function directDeleteQuery()
    {
        $this->TestPostgres->setUp("dummy");
        $this->TestPostgres->directDeleteQuery();
        echo count($this->TestPostgres->pop());
    }

    public function annotationDeleteQuery()
    {
        $this->TestPostgres->setUp("dummy");
        $this->TestPostgres->annotationDeleteQuery();
        echo count($this->TestPostgres->pop());
    }

    public function print($result)
    {
        echo $result->toArray()[0]["name"];
    }
}
