<?php
namespace WebStream\Test\TestData\Sample\App\Controller;

use WebStream\Core\CoreController;
use WebStream\Annotation\Filter;

class TestOverrideParentFilterController extends CoreController
{
    /**
     * @Filter(type="before")
     */
    public function before()
    {
        echo "b2";
    }

    /**
     * @Filter(type="after")
     */
    public function after()
    {
        echo "a2";
    }
}

class TestOverrideFilterController extends TestOverrideParentFilterController
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
