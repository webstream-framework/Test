<?php
namespace WebStream\Test\IntegrationTest\Model;

use WebStream\Core\CoreModel;
use WebStream\Annotation\Query;
use WebStream\Annotation\Database;

/**
 * @Database(driver="WebStream\Database\Driver\Mysql", config="config/database.mysql.ini")
 */
class TestMysqlModel extends CoreModel
{
    public function directSelectQuery()
    {
        $sql = "select * from T_WebStream limit :limit, :offset";
        $bind = ["limit" => 0, "offset" => 1];

        return $this->select($sql, $bind);
    }

    /**
     * @Query(file="query/webstream-test-mapper.xml")
     */
    public function annotationSelectQuery()
    {
        return $this->queryAnnotationSelect(["limit" => 0, "offset" => 1]);
    }

    public function directInsertQuery($name)
    {
        $sql = "INSERT INTO T_WebStream (name) VALUES (:name)";
        $bind = ["name" => $name];

        $this->insert($sql, $bind);
    }

    /**
     * @Query(file="query/webstream-test-mapper.xml")
     */
    public function annotationInsertQuery($name)
    {
        $this->queryAnnotationInsert(["name" => $name]);
    }

    /**
     * @Query(file="query/webstream-test-mysql-common-mapper.xml")
     */
    public function setUp($name)
    {
        $this->querySetUp(['name' => $name]);
    }

    /**
     * @Query(file="query/webstream-test-mysql-common-mapper.xml")
     */
    public function cleanUp()
    {
        $this->queryCleanUp();
    }

    /**
     * @Query(file="query/webstream-test-mysql-common-mapper.xml")
     */
    public function pop()
    {
        return $this->queryPop();
    }
}
