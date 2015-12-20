<?php
namespace WebStream\Test\TestData\Sample\App\Model;

use WebStream\Core\CoreModel;
use WebStream\Annotation\ExceptionHandler;
use WebStream\Test\TestData\Sample\App\Annotation\CustomAnnotation1;
use WebStream\Test\TestData\Sample\App\Annotation\CustomAnnotation2;

class TestCustomMethodAnnotationModel extends CoreModel
{
    /**
     * @CustomAnnotation1(exception=false)
     */
    public function model1()
    {
        echo "niconiconi-";
    }

    /**
     * @CustomAnnotation1(exception=true)
     */
    public function model2()
    {
    }

    /**
     * @CustomAnnotation2
     */
    public function model3()
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
