<?php
namespace WebStream\Test\IntegrationTest\Model;

use WebStream\Core\CoreModel;
use WebStream\Annotation\Database;

/**
 * @Database(driver="WebStream\Database\Driver\Mysql", config="config/undefined.ini")
 */
class TestErrorUndefinedConfigFileModel extends CoreModel
{
    public function undefinedConfigFile()
    {
    }
}
