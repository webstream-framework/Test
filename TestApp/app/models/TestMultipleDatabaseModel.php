<?php
namespace WebStream\Test\IntegrationTest\Model;

use WebStream\Annotation\Query;
use WebStream\Annotation\Database;

/**
 * @Database(driver="WebStream\Database\Driver\Mysql", config="config/database.mysql.ini")
 */
class TestMultipleDatabaseModel extends TestParentMultipleDatabaseModel
{
    /**
     * @Query(file="query/webstream-test-mysql-mapper.xml")
     * @Query(file="query/webstream-test-common-mapper.xml")
     */
    public function multipleDatabaseAccess()
    {
        $this->querySetUp(['name' => "multiple_database_access"]);
        $result1 = $this->queryAnnotationSelect(["limit" => 0, "offset" => 1]);
        $this->queryCleanUp();
        $result2 = parent::multipleDatabaseAccess();

        return [$result1, $result2];
    }
}
