<?php
namespace WebStream\Test\TestData\Sample\App\Model;

use WebStream\Core\CoreModel;
use WebStream\Annotation\Query;
use WebStream\Annotation\Database;

/**
 * @Database(driver="WebStream\Database\Driver\Mysql", config="config/database.mysql.yaml")
 */
class TestMysqlYamlModel extends CoreModel
{
    /**
     * @Query(file="query/webstream-model-mapper-sample.xml")
     */
    public function model1($bind = [])
    {
        return $this->getTestData(["limit" => 0, "offset" => 1]);
    }

    /**
     * @Query(file="query/webstream-model-mapper-sample.xml")
     */
    public function prepare()
    {
        $bind = ['name' => "honoka"];
        $this->beginTransaction();
        $this->deleteTestData();
        if ($this->setTestData($bind) !== 0) {
            $this->commit();

            return true;
        } else {
            $this->rollback();

            return false;
        }
    }

    /**
     * @Query(file="query/webstream-model-mapper-sample.xml")
     */
    public function clear()
    {
        $this->beginTransaction();
        if ($this->deleteTestData() !== 0) {
            $this->commit();

            return true;
        } else {
            $this->rollback();

            return false;
        }
    }
}
