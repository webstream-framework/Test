<?php
namespace WebStream\Test\IntegrationTest\Model;

use WebStream\Core\CoreModel;
use WebStream\Annotation\Query;
use WebStream\Annotation\Database;

/**
 * @Database(driver="WebStream\Database\Driver\Postgresql", config="config/database.postgresql.ini")
 */
class TestParentMultipleDatabaseModel extends CoreModel
{
    /**
     * @Query(file="query/webstream-test-postgres-mapper.xml")
     */
    public function multipleDatabaseAccess()
    {
        $this->setUp("multiple_database_access");
        $result = $this->queryAnnotationSelect(["limit" => 1, "offset" => 0]);
        $this->cleanUp();

        return $result;
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
