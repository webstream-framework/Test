<?php
namespace WebStream\Test\TestData\Sample\App\Controller;

use WebStream\Core\CoreController;
use WebStream\Annotation\Filter;

class TestInitializeFilterController extends CoreController
{
    /**
     * @Filter(type="initialize")
     */
    public function initialize()
    {
    }

    public function index()
    {
    }
}
