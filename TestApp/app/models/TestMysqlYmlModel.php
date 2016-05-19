<?php
namespace WebStream\Test\IntegrationTest\Model;

use WebStream\Core\CoreModel;
use WebStream\Annotation\Query;
use WebStream\Annotation\Database;

/**
 * @Database(driver="WebStream\Database\Driver\Mysql", config="config/database.mysql.yml")
 */
class TestMysqlYmlModel extends CoreModel
{
    public function directSelectQuery()
    {
        $sql = "SELECT * FROM T_WebStream LIMIT :limit, :offset";
        $bind = ["limit" => 0, "offset" => 1];

        return $this->select($sql, $bind);
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
}
