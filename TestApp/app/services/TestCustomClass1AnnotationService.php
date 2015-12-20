<?php
namespace WebStream\Test\TestData\Sample\App\Service;

use WebStream\Core\CoreService;
use WebStream\Test\TestData\Sample\App\Annotation\CustomAnnotation4;

/**
 * @CustomAnnotation4
 */
class TestCustomClass1AnnotationService extends CoreService
{
    public function service1()
    {
        echo "service";
    }
}
