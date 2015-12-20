<?php
namespace WebStream\Test\TestData\Sample\App\Model;

use WebStream\Core\CoreModel;
use WebStream\Test\TestData\Sample\App\Annotation\CustomAnnotation4;

/**
 * @CustomAnnotation4
 */
class TestCustomClass1AnnotationModel extends CoreModel
{
    public function model1()
    {
        echo "model";
    }
}
