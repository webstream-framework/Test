<?php
namespace WebStream\Test\IntegrationTest\Model;

use WebStream\Core\CoreModel;
use WebStream\Annotation\Query;
use WebStream\Annotation\Database;

/**
 * @Database(driver="WebStream\Database\Driver\Mysql", config="config/database.mysql.ini")
 */
class TestErrorUndefinedQueryModel extends CoreModel
{
    /**
     * @Query(file="query/webstream-test-mysql-mapper.xml")
     */
    public function undefinedQuery()
    {
        $this->undefined();
    }

    /**
     * @Query(file="query/webstream-test-entity-mapper.xml")
     */
    public function undefinedQueryMapping()
    {
        $this->queryUndefinedEntitySelect();
    }
}
