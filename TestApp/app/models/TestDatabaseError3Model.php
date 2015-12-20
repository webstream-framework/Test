<?php
namespace WebStream\Test\TestData\Sample\App\Model;

use WebStream\Core\CoreModel;
use WebStream\Annotation\Query;
use WebStream\Annotation\Database;

/**
 * @Database(driver="WebStream\Database\Driver\Mysql", config="config/database.mysql.ini")
 */
class TestDatabaseError3Model extends CoreModel
{
    /**
     * @Query(file="query/webstream-invalid-model-mapper-sample.xml")
     */
    public function model1()
    {
        $bind = ["limit" => 0, "offset" => 1];

        return $this->getTestData($bind);
    }

    /**
     * @Query(file="query/webstream-model-mapper-sample-entity.xml")
     */
    public function model2()
    {
        $this->entityMappingInvalidClassPath();
    }
}
