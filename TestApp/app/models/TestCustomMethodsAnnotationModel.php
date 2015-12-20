<?php
namespace WebStream\Test\TestData\Sample\App\Model;

use WebStream\Core\CoreModel;
use WebStream\Test\TestData\Sample\App\Annotation\CustomAnnotation3;

class TestCustomMethodsAnnotationModel extends CoreModel
{
    public function model1()
    {
        echo "ni-";
    }

    /**
     * @CustomAnnotation3
     */
    public function read1()
    {
    }

    /**
     * @CustomAnnotation3
     */
    public function read2()
    {
    }
}
