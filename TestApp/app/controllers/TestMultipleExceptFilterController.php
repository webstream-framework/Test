<?php
namespace WebStream\Test\TestData\Sample\App\Controller;

use WebStream\Core\CoreController;
use WebStream\Annotation\Filter;

class TestMultipleExceptFilterController extends CoreController
{
    /**
     * @Filter(type="before", except={"index", "index2"})
     */
    public function before()
    {
        echo "b";
    }

    /**
     * @Filter(type="after", except={"index3", "index4"})
     */
    public function after()
    {
        echo "a";
    }

    public function index()
    {
        echo "i1";
    }

    public function index2()
    {
        echo "i2";
    }

    public function index3()
    {
        echo "i3";
    }

    public function index4()
    {
        echo "i4";
    }
}
