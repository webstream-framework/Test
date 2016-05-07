<?php
namespace WebStream\Test\TestData\Sample\App\Controller;

use WebStream\Core\CoreController;
use WebStream\Annotation\Filter;

class TestInvalidFilterController extends CoreController
{
    /**
     * @Filter("test", "test")
     */
    public function invalid()
    {
    }

    public function index()
    {
    }
}
