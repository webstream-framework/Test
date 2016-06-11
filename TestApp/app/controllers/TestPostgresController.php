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


    public function entityMapping1()
    {
        $this->TestPostgres->cleanUp();
        $this->TestPostgres->setUp("dummy");
        foreach ($this->TestPostgres->entityMapping1() as $entity) {
            echo get_class($entity);
        }
    }

    public function entityMapping2()
    {
        $this->TestPostgres->cleanUp();
        foreach ($this->TestPostgres->entityMapping2() as $entity) {
            echo get_class($entity);
        }
    }

    public function entityMappingJoinedTable()
    {
        $this->TestPostgres->cleanUp();
        foreach ($this->TestPostgres->entityMappingJoinedTable() as $entity) {
            echo $entity->getName();
            echo $entity->getValue1();
            echo $entity->getValue2();
            echo $entity->getValue3();
        }
    }

    public function entityMappingColumnAlias()
    {
        $this->TestPostgres->cleanUp();
        foreach ($this->TestPostgres->entityMappingColumnAlias() as $entity) {
            echo $entity->getName1();
            echo $entity->getName2();
        }
    }

    public function entityMappingType()
    {
        $this->TestPostgres->cleanUp();
        foreach ($this->TestPostgres->entityMappingType() as $entity) {
            echo gettype($entity->getId());
            echo gettype($entity->getName());
            echo gettype($entity->getCreatedAt());
            echo gettype($entity->getCreatedAtTime());
            echo gettype($entity->getCreatedAtDate());
            echo gettype($entity->getBigintNum());
            echo gettype($entity->getSmallintNum());
        }
    }

    public function entityMappingTrait()
    {
        $this->TestPostgres->cleanUp();
        foreach ($this->TestPostgres->entityMappingTrait() as $entity) {
            echo $entity->getName1();
            echo $entity->getName2();
        }
    }

    public function entityMappingPropertyProxy()
    {
        $this->TestPostgres->cleanUp();
        foreach ($this->TestPostgres->entityMappingPropertyProxy() as $entity) {
            echo $entity->name;
        }
    }

    public function transactionCommit()
    {
        $this->TestPostgres->cleanUp();
        $this->TestPostgres->transactionCommit();
        $result = $this->TestPostgres->annotationSelectQuery();
        echo $result->toArray()[0]["name"];
    }

    public function transactionRollback()
    {
        $this->TestPostgres->cleanUp();
        $this->TestPostgres->transactionRollback();
        $result = $this->TestPostgres->annotationSelectQuery();
        echo count($result->toArray());
    }

    public function print($result)
    {
        echo $result->toArray()[0]["name"];
    }
}
