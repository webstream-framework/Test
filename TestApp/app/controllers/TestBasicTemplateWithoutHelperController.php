<?php
namespace WebStream\Test\TestData\Sample\App\Controller;

use WebStream\Core\CoreController;
use WebStream\Annotation\Template;

class TestBasicTemplateWithoutHelperController extends CoreController
{
    /**
     * @Template("index1.tmpl")
     */
    public function index1()
    {
        // helperオブジェクトがCoreExceptionDelegator
    }

    /**
     * @Template("error1.tmpl")
     */
    public function error1()
    {
        // helperなし
    }
}
