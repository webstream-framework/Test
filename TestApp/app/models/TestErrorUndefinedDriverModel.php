<?php
namespace WebStream\Test\IntegrationTest\Model;

use WebStream\Core\CoreModel;
use WebStream\Annotation\Database;

/**
 * @Database(driver="WebStream\Database\Driver\UndefinedDriver", config="config/database.mysql.ini")
 */
class TestErrorUndefinedDriverModel extends CoreModel
{
    public function undefinedDriver()
    {
    }
}
