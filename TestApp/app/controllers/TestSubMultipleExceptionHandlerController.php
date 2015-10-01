<?php
namespace WebStream\Test\TestData\Sample\App\Controller;

use WebStream\Annotation\Inject;
use WebStream\Annotation\ExceptionHandler;
use WebStream\Exception\Extend\ResourceNotFoundException;

class TestSubMultipleExceptionHandlerController extends TestMultipleExceptionHandlerController
{
    public function index1()
    {
        throw new ResourceNotFoundException();
    }

    /**
     * @Inject
     * @ExceptionHandler("WebStream\Exception\Extend\ResourceNotFoundException")
     */
    public function subException($params)
    {
        echo "1";
    }
}
