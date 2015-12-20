<?php
namespace WebStream\Test\TestData\Sample\App\Model;

use WebStream\Core\CoreModel;
use WebStream\Annotation\Query;
use WebStream\Annotation\Database;

/**
 * @Database(driver="WebStream\Database\Driver\Postgresql", config="config/database.postgresql.ini")
 */
class TestSuperMultipleDatabaseModel extends CoreModel
{
    /**
     * @Query(file="query/webstream-model-mapper-sample-multipledb.xml")
     */
    public function model1()
    {
        $bind = ["limit" => 1, "offset" => 0];

        return $this->usePostgres($bind);
    }
}
