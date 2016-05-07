<?php
namespace WebStream\Test\TestData\Sample\App\Controller;

use WebStream\Core\CoreController;
use WebStream\Annotation\Template;

class TestBasicTemplateWithServiceController extends CoreController
{
    /**
     * @Template("index1.tmpl")
     */
    public function index1()
    {
        // serviceオブジェクトが取得できること
    }
}
