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
     * @Query(file="query/webstream-test-common-mapper.xml")
     */
    public function multipleDatabaseAccess()
    {
        $this->querySetUp(['name' => "multiple_database_access"]);
        $result = $this->queryAnnotationSelect(["limit" => 1, "offset" => 0]);
        $this->queryCleanUp();

        return $result;
    }
}
