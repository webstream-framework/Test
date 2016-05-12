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
    public function selectDirectSqlExecute()
    {
        echo "test1";
    }

    public function selectAnnotationExecute()
    {

    }



    /**
     * @Query(file="query/webstream-test-common-mapper.xml")
     */
    public function setUp($name)
    {
        $this->querySetUp(['name' => $name]);
    }

    public function cleanUp()
    {

    }
}
