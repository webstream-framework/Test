<?php
namespace WebStream\Test\TestData\Sample\App\Model;

use WebStream\Core\CoreModel;
use WebStream\Annotation\Query;
use WebStream\Annotation\Database;

/**
 * @Database(driver="WebStream\Database\Driver\Mysql", config="config/dummy.ini")
 */
class TestDatabaseError2Model extends CoreModel
{
    public function model1()
    {
    }
}
