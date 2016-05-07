<?php
namespace WebStream\Test\TestData\Sample\App\Model;

use WebStream\Core\CoreModel;
use WebStream\Annotation\Autowired;

class TestAutowiredModel extends CoreModel
{
    /**
     * @Autowired(value="umichang");
     */
    private $name;

    public function model1()
    {
        echo $this->name;
    }
}
