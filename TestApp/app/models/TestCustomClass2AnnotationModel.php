<?php
namespace WebStream\Test\TestData\Sample\App\Model;

use WebStream\Core\CoreModel;
use WebStream\Test\TestData\Sample\App\Annotation\CustomAnnotation5;

/**
 * @CustomAnnotation5
 */
class TestCustomClass2AnnotationModel extends CoreModel
{
    public function model1()
    {
        echo $this->annotation["WebStream\Test\TestData\Sample\App\Annotation\CustomAnnotation5"][0];
        echo "model";
    }
}
