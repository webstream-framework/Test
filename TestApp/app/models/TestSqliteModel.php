<?php
namespace WebStream\Test\IntegrationTest\Model;

use WebStream\Core\CoreModel;
use WebStream\Annotation\Query;
use WebStream\Annotation\Database;

/**
 * @Database(driver="WebStream\Database\Driver\Sqlite", config="config/database.sqlite.ini")
 */
class TestSqliteModel extends CoreModel
{
    public function directSelectQuery()
    {
        $sql = "SELECT * FROM T_WebStream LIMIT :limit OFFSET :offset";
        $bind = ["limit" => 1, "offset" => 0];

        return $this->select($sql, $bind);
    }

    /**
     * @Query(file="query/webstream-test-sqlite-mapper.xml")
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
     * @Query(file="query/webstream-test-sqlite-mapper.xml")
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
     * @Query(file="query/webstream-test-sqlite-mapper.xml")
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
     * @Query(file="query/webstream-test-sqlite-mapper.xml")
     */
    public function annotationDeleteQuery()
    {
        return $this->queryAnnotationDelete();
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
     */
    public function cleanUp()
    {
        $this->queryCleanUp();
    }

    /**
     * @Query(file="query/webstream-test-common-mapper.xml")
     */
    public function pop()
    {
        return $this->queryPop();
    }
}
