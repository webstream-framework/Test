<?php
namespace WebStream\Test\TestData\Sample\App\Service;

use WebStream\Core\CoreService;
use WebStream\Test\TestData\Sample\App\Annotation\CustomAnnotation3;

class TestCustomMethodsAnnotationService extends CoreService
{
    public function service1()
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
