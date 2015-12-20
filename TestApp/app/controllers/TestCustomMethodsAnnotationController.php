<?php
namespace WebStream\Test\TestData\Sample\App\Controller;

use WebStream\Core\CoreController;
use WebStream\Test\TestData\Sample\App\Annotation\CustomAnnotation3;

class TestCustomMethodsAnnotationController extends CoreController
{
    public function index1()
    {
        echo "ni-";
    }

    public function index2()
    {
        $this->TestCustomMethodsAnnotation->service1();
    }

    public function index3()
    {
        $this->TestCustomMethodsAnnotation->model1();
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
