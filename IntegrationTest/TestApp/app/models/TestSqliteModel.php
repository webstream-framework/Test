<?php
namespace WebStream\Test\TestData\Sample\App\Model;

use WebStream\Core\CoreModel;
use WebStream\Annotation\Query;
use WebStream\Annotation\Database;

/**
 * @Database(driver="WebStream\Database\Driver\Sqlite", config="config/database.sqlite.ini")
 */
class TestSqliteModel extends CoreModel
{
    public function model1()
    {
        $sql = "select * from T_WebStream limit :limit, :offset";
        $bind = ["limit" => 0, "offset" => 1];

        return $this->select($sql, $bind);
    }

    /**
     * @Query(file="query/webstream-model-mapper-sample.xml")
     */
    public function model2()
    {
        $bind = ["limit" => 0, "offset" => 1];

        return $this->getTestData($bind);
    }

    /**
     * @Query(file="query/dummy.xml")
     */
    public function model3()
    {
        $this->dummy();
    }

    public function model4()
    {
        // Modelメソッドを直接Controllerから呼ばないパターン
        return $this->model4_2();
    }

    /**
     * @Query(file="query/webstream-model-mapper-sample-innercall.xml")
     */
    public function model4_2()
    {
        $bind = ["limit" => 1, "offset" => 0];

        return $this->innerSelectSqlite($bind);
    }

    /**
     * @Query(file="query/webstream-model-mapper-sample-entity.xml")
     */
    public function model5()
    {
        return $this->entityMappingSqlite(["limit" => 1, "offset" => 0]);
    }

    /**
     * @Query(file="query/webstream-model-mapper-sample-entity.xml")
     */
    public function model6()
    {
        return $this->entityMappingSqlite2(["limit" => 1, "offset" => 0]);
    }

    /**
     * @Query(file="query/webstream-model-mapper-sample-entity.xml")
     */
    public function model7()
    {
        return $this->entityMappingMultipleTableSqlite();
    }

    /**
     * @Query(file="query/webstream-model-mapper-sample-entity.xml")
     */
    public function model8()
    {
        return $this->entityMappingAliasSqlite();
    }

    /**
     * @Query(file="query/webstream-model-mapper-sample-entity.xml")
     */
    public function model9()
    {
        return $this->entityMappingTypeSqlite();
    }

    /**
     * @Query(file="query/webstream-model-mapper-sample.xml")
     * @Query(file="query/webstream-model-mapper-sample-entity.xml")
     */
    public function model10()
    {
        $result1 = $this->getTestData2(["limit" => 1, "offset" => 0]);
        $result2 = $this->entityMappingSqlite(["limit" => 1, "offset" => 0]);

        return [$result1, $result2];
    }

    /**
     * @Query(file={"query/webstream-model-mapper-sample.xml", "query/webstream-model-mapper-sample-entity.xml"})
     */
    public function model11()
    {
        $result1 = $this->getTestData2(["limit" => 1, "offset" => 0]);
        $result2 = $this->entityMappingSqlite(["limit" => 1, "offset" => 0]);

        return [$result1, $result2];
    }

    /**
     * @Query(file="query/webstream-model-mapper-sample-trait-entity.xml")
     */
    public function model12()
    {
        $result = $this->entityMappingSqlite(["limit" => 1, "offset" => 0]);

        return $result;
    }

    /**
     * @Query(file="query/webstream-model-mapper-sample.xml")
     */
    public function prepare()
    {
        $bind = ['name' => "umichang"];
        $this->deleteTestData();

        return $this->setTestData($bind) !== 0;
    }

    /**
     * @Query(file="query/webstream-model-mapper-sample-entity.xml")
     */
    public function prepare2()
    {
        $bind = ['value1' => "honoka", 'value2' => "kotori", 'value3' => "umichang"];
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
     * @Query(file="query/webstream-model-mapper-sample-entity.xml")
     */
    public function prepare3()
    {
        $bind = ['name' => "elichika", 'bigint_num' => 9223372036854775807, 'smallint_num' => 3];
        $this->beginTransaction();
        $this->deleteTestData2();
        if ($this->setTestData3($bind) !== 0) {
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
        return $this->deleteTestData() !== 0;
    }

    /**
     * @Query(file="query/webstream-model-mapper-sample-entity.xml")
     */
    public function clear2()
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

    /**
     * @Query(file="query/webstream-model-mapper-sample-entity.xml")
     */
    public function clear3()
    {
        $this->beginTransaction();
        if ($this->deleteTestData2() !== 0) {
            $this->commit();

            return true;
        } else {
            $this->rollback();

            return false;
        }
    }
}
