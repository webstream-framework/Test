<?php
namespace WebStream\Test\TestData\Sample\App\Model;

use WebStream\Core\CoreModel;
use WebStream\Annotation\Query;
use WebStream\Annotation\Database;

/**
 * @Database(driver="WebStream\Database\Driver\Mysql", config="config/database.mysql.ini")
 */
class TestMysqlModel extends CoreModel
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
    public function model2($bind = [])
    {
        $bind = ["limit" => 0, "offset" => 1];

        return $this->getTestData($bind);
    }

    /**
     * @Query(file="query/webstream-model-mapper-sample.xml")
     */
    public function model3()
    {
        $this->beginTransaction();
        $bind = ["name" => "kotori"];
        $this->setTestData($bind);
        $this->commit();

        $bind = ["limit" => 0, "offset" => 1];

        return $this->getTestData($bind);
    }

    /**
     * @Query(file="query/webstream-model-mapper-sample.xml")
     */
    public function model4()
    {
        $this->beginTransaction();
        $bind = ["name" => "kotori"];
        $this->setTestData($bind);
        $this->rollback();

        return $this->getTestDataNum();
    }

    /**
     * @Query(file="query/dummy.xml")
     */
    public function model5()
    {
        $this->dummy();
    }

    /**
     * @Query(file="query/webstream-model-mapper-sample.xml")
     */
    public function model6()
    {
        $bind = ["name" => "kotori"];
        $this->setTestData($bind);

        return $this->getTestDataNum();
    }

    public function model7()
    {
        // Modelメソッドを直接Controllerから呼ばないパターン
        return $this->model7_2();
    }

    /**
     * @Query(file="query/webstream-model-mapper-sample-innercall.xml")
     */
    public function model7_2()
    {
        $bind = ["limit" => 0, "offset" => 1];

        return $this->innerSelectMysql($bind);
    }

    /**
     * @Query(file="query/webstream-model-mapper-sample-entity.xml")
     */
    public function model8()
    {
        return $this->entityMappingMysql(["limit" => 0, "offset" => 1]);
    }

    /**
     * @Query(file="query/webstream-model-mapper-sample-entity.xml")
     */
    public function model9()
    {
        return $this->entityMappingMysql2(["limit" => 0, "offset" => 1]);
    }

    /**
     * @Query(file="query/webstream-model-mapper-sample-entity.xml")
     */
    public function model10()
    {
        return $this->entityMappingMultipleTableMysql();
    }

    /**
     * @Query(file="query/webstream-model-mapper-sample-entity.xml")
     */
    public function model11()
    {
        return $this->entityMappingAliasMysql();
    }

    /**
     * @Query(file="query/webstream-model-mapper-sample-entity.xml")
     */
    public function model12()
    {
        return $this->entityMappingTypeMysql();
    }

    /**
     * @Query(file="query/webstream-model-mapper-sample.xml")
     * @Query(file="query/webstream-model-mapper-sample-entity.xml")
     */
    public function model13()
    {
        $result1 = $this->getTestData(["limit" => 0, "offset" => 1]);
        $result2 = $this->entityMappingMysql(["limit" => 0, "offset" => 1]);

        return [$result1, $result2];
    }

    /**
     * @Query(file={"query/webstream-model-mapper-sample.xml", "query/webstream-model-mapper-sample-entity.xml"})
     */
    public function model14()
    {
        $result1 = $this->getTestData(["limit" => 0, "offset" => 1]);
        $result2 = $this->entityMappingMysql(["limit" => 0, "offset" => 1]);

        return [$result1, $result2];
    }

    /**
     * @Query(file="query/webstream-model-mapper-sample-trait-entity.xml")
     */
    public function model15()
    {
        $result = $this->entityMappingMysql(["limit" => 0, "offset" => 1]);

        return $result;
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
        if ($this->setTestData2($bind) !== 0) {
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
