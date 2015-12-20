<?php
namespace WebStream\Test\TestData\Sample\App\Service;

use WebStream\Core\CoreService;
use WebStream\Test\TestData\Sample\App\Annotation\CustomAnnotation5;

/**
 * @CustomAnnotation5
 */
class TestCustomClass2AnnotationService extends CoreService
{
    public function service1()
    {
        echo $this->annotation["WebStream\Test\TestData\Sample\App\Annotation\CustomAnnotation5"][0];
        echo "service";
    }
}
