<?php
namespace WebStream\Test\TestData\Sample\App\Controller;

use WebStream\Core\CoreController;
use WebStream\Annotation\Filter;

class TestFilterController extends CoreController
{
    /**
     * @Filter(type="before")
     */
    public function before()
    {
        echo "b";
    }

    /**
     * @Filter(type="after")
     */
    public function after()
    {
        echo "a";
    }

    public function index()
    {
        echo "i";
    }
}
