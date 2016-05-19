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
     * @Query(file="query/webstream-model-mapper-sample-multipledb.xml")
     */
    public function multipleDatabaseAccess()
    {
        $this->setUp("multiple_database_access");
        $result1 = $this->queryAnnotationSelect(["limit" => 0, "offset" => 1]);
        var_dump($result1);
        $this->cleanUp();
        $result2 = parent::multipleDatabaseAccess();

        return [$result1, $result2];
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
