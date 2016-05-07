<?php
namespace WebStream\Test\TestData\Sample\App\Controller;

use WebStream\Core\CoreController;
use WebStream\Annotation\Filter;

class TestParentFilterController extends CoreController
{
    /**
     * @Filter(type="before")
     */
    public function before2()
    {
        echo "b2";
    }

    /**
     * @Filter(type="after")
     */
    public function after2()
    {
        echo "a2";
    }
}

class TestMultipleFilterController extends TestParentFilterController
{
    /**
     * @Filter(type="before")
     */
    public function before()
    {
        echo "b1";
    }

    /**
     * @Filter(type="after")
     */
    public function after()
    {
        echo "a1";
    }

    public function index()
    {
        echo "i";
    }
}
