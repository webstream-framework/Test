<?php
namespace WebStream\Test\TestData\Sample\App\Controller;

use WebStream\Core\CoreController;
use WebStream\Test\TestData\Sample\App\Annotation\CustomAnnotation6;

class TestCustomProperty1AnnotationController extends CoreController
{
    /**
     * @CustomAnnotation6
     */
    private $name;

    public function index1()
    {
    }
}
