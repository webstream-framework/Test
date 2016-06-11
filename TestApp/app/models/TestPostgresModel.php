<?php
namespace WebStream\Test\IntegrationTest\Model;

use WebStream\Core\CoreModel;
use WebStream\Annotation\Query;
use WebStream\Annotation\Database;

/**
 * @Database(driver="WebStream\Database\Driver\Postgresql", config="config/database.postgresql.ini")
 */
class TestPostgresModel extends CoreModel
{
    public function directSelectQuery()
    {
        $sql = "SELECT * FROM T_WebStream LIMIT :limit OFFSET :offset";
        $bind = ["limit" => 1, "offset" => 0];

        return $this->select($sql, $bind);
    }

    /**
     * @Query(file="query/webstream-test-postgres-mapper.xml")
     */
    public function annotationSelectQuery()
    {
        return $this->queryAnnotationSelect(["limit" => 1, "offset" => 0]);
    }

    public function directInsertQuery($name)
    {
        $sql = "INSERT INTO T_WebStream (name) VALUES (:name)";
        $bind = ["name" => $name];

        return $this->insert($sql, $bind);
    }

    /**
     * @Query(file="query/webstream-test-postgres-mapper.xml")
     */
    public function annotationInsertQuery($name)
    {
        return $this->queryAnnotationInsert(["name" => $name]);
    }

    public function directUpdateQuery($name)
    {
        $sql = "UPDATE T_WebStream SET name = :name";
        $bind = ["name" => $name];

        return $this->update($sql, $bind);
    }

    /**
     * @Query(file="query/webstream-test-postgres-mapper.xml")
     */
    public function annotationUpdateQuery($name)
    {
        return $this->queryAnnotationUpdate(["name" => $name]);
    }

    public function directDeleteQuery()
    {
        $sql = "DELETE FROM T_WebStream";

        return $this->delete($sql);
    }

    /**
     * @Query(file="query/webstream-test-postgres-mapper.xml")
     */
    public function annotationDeleteQuery()
    {
        return $this->queryAnnotationDelete();
    }

    /**
     * @Query(file="query/webstream-test-entity-mapper.xml")
     */
    public function entityMapping1()
    {
        return $this->queryEntitySelect1();
    }

    /**
     * @Query(file="query/webstream-test-entity-mapper.xml")
     */
    public function entityMapping2()
    {
        $this->queryEntityMappingDelete();
        $this->queryEntityMappingInsert(['value1' => "a", 'value2' => "b", 'value3' => "c"]);

        return $this->queryEntitySelect2();
    }

    /**
     * @Query(file="query/webstream-test-common-mapper.xml")
     * @Query(file="query/webstream-test-entity-mapper.xml")
     */
    public function entityMappingJoinedTable()
    {
        $this->querySetUp(['name' => 'a']);
        $this->queryEntityMappingInsert(['value1' => "b", 'value2' => "c", 'value3' => "d"]);

        return $this->queryEntityJoinedTable();
    }

    /**
     * @Query(file="query/webstream-test-common-mapper.xml")
     * @Query(file="query/webstream-test-entity-mapper.xml")
     */
    public function entityMappingColumnAlias()
    {
        $this->querySetUp(['name' => 'a']);

        return $this->queryEntityColumnAlias();
    }

    /**
     * @Query(file="query/webstream-test-entity-mapper.xml")
     */
    public function entityMappingType()
    {
        $this->queryEntityMappingTypeInsert(['name' => "a", 'bigint_num' => 9223372036854775807, 'smallint_num' => 3]);

        return $this->queryEntityType();
    }

    /**
     * @Query(file="query/webstream-test-postgres-mapper.xml")
     * @Query(file="query/webstream-test-entity-mapper.xml")
     */
    public function entityMappingTrait()
    {
        $this->queryAnnotationInsert(["name" => 'a']);

        return $this->queryEntityTrait();
    }

    /**
     * @Query(file="query/webstream-test-postgres-mapper.xml")
     * @Query(file="query/webstream-test-entity-mapper.xml")
     */
    public function entityMappingPropertyProxy()
    {
        $this->queryAnnotationInsert(["name" => 'a']);

        return $this->queryEntityPropertyProxy();
    }

    /**
     * @Query(file="query/webstream-test-postgres-mapper.xml")
     */
    public function transactionCommit()
    {
        $this->beginTransaction();
        $this->queryAnnotationInsert(["name" => 'a']);
        $this->commit();
    }

    /**
     * @Query(file="query/webstream-test-postgres-mapper.xml")
     */
    public function transactionRollback()
    {
        $this->beginTransaction();
        $this->queryAnnotationInsert(["name" => 'a']);
        $this->rollback();
    }

    /**
     * @Query(file="query/webstream-test-common-mapper.xml")
     */
    public function setUp($name)
    {
        $this->querySetUp(['name' => $name]);
    }

    /**
     * @Query(file="query/webstream-test-common-mapper.xml")
     * @Query(file="query/webstream-test-entity-mapper.xml")
     */
    public function cleanUp()
    {
        $this->queryCleanUp();
        $this->queryEntityMappingDelete();
        $this->queryEntityMappingTypeDelete();
    }

    /**
     * @Query(file="query/webstream-test-common-mapper.xml")
     */
    public function pop()
    {
        return $this->queryPop();
    }
}
