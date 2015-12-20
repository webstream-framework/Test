<?php
namespace WebStream\Test\TestData\Sample\App\Controller;

use WebStream\Core\CoreService;
use WebStream\Annotation\ExceptionHandler;
use WebStream\Test\TestData\Sample\App\Annotation\CustomAnnotation1;
use WebStream\Test\TestData\Sample\App\Annotation\CustomAnnotation2;

class TestCustomMethodAnnotationService extends CoreService
{
    /**
     * @CustomAnnotation1(exception=false)
     */
    public function service1()
    {
        echo "niconiconi-";
    }

    /**
     * @CustomAnnotation1(exception=true)
     */
    public function service2()
    {
    }

    /**
     * @CustomAnnotation2
     */
    public function service3()
    {
        echo $this->annotation["WebStream\Test\TestData\Sample\App\Annotation\CustomAnnotation2"][0];
    }

    /**
     * @ExceptionHandler("\Exception")
     */
    public function exceptionHandler($params)
    {
        echo "makimakima-";
    }
}
