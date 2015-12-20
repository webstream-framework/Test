<?php
namespace WebStream\Test\TestData\Sample\App\Controller;

use WebStream\Core\CoreController;
use WebStream\Annotation\Filter;

class TestSkipFilterController extends CoreController
{
    /**
     * @Filter(type="before")
     */
    public function before1()
    {
        echo "b1";
    }

    /**
     * @Filter(type="before")
     */
    public function before2()
    {
        echo "b2";
    }

    /**
     * @Filter(type="skip", except="before1")
     */
    public function index1()
    {
        echo "i";
    }

    /**
     * @Filter(type="skip", except={"before1","before2"})
     */
    public function index2()
    {
        echo "i";
    }
}
