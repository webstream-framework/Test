<?php
namespace WebStream\Test\TestData\Sample\App\Controller;

use WebStream\Core\CoreController;
use WebStream\Annotation\Inject;
use WebStream\Test\TestData\Sample\App\Annotation\CustomAnnotation5;

/**
 * @Inject
 * @CustomAnnotation5
 */
class TestCustomClass2AnnotationController extends CoreController
{
    public function index1()
    {
        echo $this->annotation["WebStream\Test\TestData\Sample\App\Annotation\CustomAnnotation5"][0];
    }

    public function index2()
    {
        $this->TestCustomClass2Annotation->service1();
    }

    public function index3()
    {
        $this->TestCustomClass2Annotation->model1();
    }
}
