<?php
namespace WebStream\Test\TestData\Sample\App\Helper;

use WebStream\Core\CoreHelper;
use WebStream\Annotation\Autowired;

class TestAutowiredHelper extends CoreHelper
{
    /**
     * @Autowired(value="kotohonoumi");
     */
    private $name;

    public function helper1()
    {
        echo $this->name;
    }
}
