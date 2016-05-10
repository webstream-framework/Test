<?php
namespace WebStream\Test\IntegrationTest\Model;

use WebStream\Core\CoreModel;

class TestNoServiceClassExistModelModel extends CoreModel
{
    public function exist()
    {
        echo "exist";
    }
}
