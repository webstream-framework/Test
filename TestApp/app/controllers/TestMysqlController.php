<?php
namespace WebStream\Test\IntegrationTest\Controller;

use WebStream\Core\CoreController;

class TestMysqlController extends CoreController
{
    public function directSelectQuery()
    {
        $this->TestMysql->cleanUp();
        $this->TestMysql->setUp("direct_select");
        $this->print($this->TestMysql->directSelectQuery());
    }

    public function annotationSelectQuery()
    {
        $this->TestMysql->cleanUp();
        $this->TestMysql->setUp("annotation_select");
        $this->print($this->TestMysql->annotationSelectQuery());
    }

    public function directInsertQuery()
    {
        $this->TestMysql->cleanUp();
        $this->TestMysql->directInsertQuery("direct_insert");
        $this->print($this->TestMysql->pop());
    }

    public function annotationInsertQuery()
    {
        $this->TestMysql->cleanUp();
        $this->TestMysql->annotationInsertQuery("annotation_insert");
        $this->print($this->TestMysql->pop());
    }

    public function directUpdateQuery()
    {
        $this->TestMysql->cleanUp();
        $this->TestMysql->setUp("dummy");
        $this->TestMysql->directUpdateQuery("direct_update");
        $this->print($this->TestMysql->pop());
    }

    public function annotationUpdateQuery()
    {
        $this->TestMysql->cleanUp();
        $this->TestMysql->setUp("dummy");
        $this->TestMysql->annotationUpdateQuery("annotation_update");
        $this->print($this->TestMysql->pop());
    }

    public function directDeleteQuery()
    {
        $this->TestMysql->cleanUp();
        $this->TestMysql->setUp("dummy");
        $this->TestMysql->directDeleteQuery();
        echo count($this->TestMysql->pop());
    }

    public function annotationDeleteQuery()
    {
        $this->TestMysql->cleanUp();
        $this->TestMysql->setUp("dummy");
        $this->TestMysql->annotationDeleteQuery();
        echo count($this->TestMysql->pop());
    }

    public function entityMapping1()
    {
        $this->TestMysql->cleanUp();
        $this->TestMysql->setUp("dummy");
        foreach ($this->TestMysql->entityMapping1() as $entity) {
            echo get_class($entity);
        }
    }

    public function entityMapping2()
    {
        $this->TestMysql->cleanUp();
        foreach ($this->TestMysql->entityMapping2() as $entity) {
            echo get_class($entity);
        }
    }

    public function entityMappingJoinedTable()
    {
        $this->TestMysql->cleanUp();
        foreach ($this->TestMysql->entityMappingJoinedTable() as $entity) {
            echo $entity->getName();
            echo $entity->getValue1();
            echo $entity->getValue2();
            echo $entity->getValue3();
        }
    }

    public function entityMappingColumnAlias()
    {
        $this->TestMysql->cleanUp();
        foreach ($this->TestMysql->entityMappingColumnAlias() as $entity) {
            echo $entity->getName1();
            echo $entity->getName2();
        }
    }

    public function entityMappingType()
    {
        $this->TestMysql->cleanUp();
        foreach ($this->TestMysql->entityMappingType() as $entity) {
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
        $this->TestMysql->cleanUp();
        foreach ($this->TestMysql->entityMappingTrait() as $entity) {
            echo $entity->getName1();
            echo $entity->getName2();
        }
    }

    public function entityMappingPropertyProxy()
    {
        $this->TestMysql->cleanUp();
        foreach ($this->TestMysql->entityMappingPropertyProxy() as $entity) {
            echo $entity->name;
        }
    }

    public function transactionCommit()
    {
        $this->TestMysql->cleanUp();
        $this->TestMysql->transactionCommit();
        $result = $this->TestMysql->annotationSelectQuery();
        echo $result->toArray()[0]["name"];
    }

    public function transactionRollback()
    {
        $this->TestMysql->cleanUp();
        $this->TestMysql->transactionRollback();
        $result = $this->TestMysql->annotationSelectQuery();
        echo count($result->toArray());
    }

    public function print($result)
    {
        echo $result->toArray()[0]["name"];
    }
}
