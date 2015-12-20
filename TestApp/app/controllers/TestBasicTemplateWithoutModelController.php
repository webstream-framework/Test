<?php
namespace WebStream\Test\TestData\Sample\App\Controller;

use WebStream\Core\CoreController;
use WebStream\Annotation\Template;

class TestBasicTemplateWithoutModelController extends CoreController
{
    /**
     * @Template("index1.tmpl")
     */
    public function index1()
    {
        // modelオブジェクトがCoreExceptionDelegator
    }

    /**
     * @Template("error1.tmpl")
     */
    public function error1()
    {
        // modelなし
    }
}
